<?php

use App\core\Model;

class Note extends Model
{
    public $titulo;
    public $texto;
    public $imagem;

    public function getAll()
    {
        $sql = "SELECT notes.id, notes.titulo, notes.texto, notes.imagem, users.id as iduser, users.nome FROM notes INNER JOIN users ON(notes.id_user = users.id)";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } else {
            return [];
        }
    }

    public function search($busca)
    {
        $sql = "SELECT * FROM notes WHERE titulo LIKE ? COLLATE utf8_general_ci";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, "%{$busca}%");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } else {
            return [];
        }
    }

    public function findId($id)
    {
        $sql = "SELECT * FROM notes WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
        } else {
            return [];
        }
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO notes (titulo, texto, imagem) VALUES (?, ?, ?)";
            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->titulo);
            $stmt->bindValue(2, $this->texto);
            $stmt->bindValue(3, $this->imagem);

            if ($stmt->execute()) {
                return "Cadastrado com sucesso";
            } else {
                return "Erro ao cadastrar";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id)
    {
        $updateImagem = "";
        if(!empty($this->imagem)){
            $updateImagem = ",imagem = ?";
        }

        $sql = "UPDATE notes SET titulo = ?, texto = ? {$updateImagem} WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->titulo);
        $stmt->bindValue(2, $this->texto);
        if(!empty($this->imagem)){
            $stmt->bindValue(3, $this->imagem);
            $stmt->bindValue(4, $id);
        } else {
            $stmt->bindValue(3, $id);
        }
        

        if ($stmt->execute()) {
            return "M.toast({html: 'Atualizado com sucesso!', classes: 'rounded, green'})";
        } else {
            return "M.toast({html: 'Erro ao cadastrar', classes: 'rounded, red'})";
        }
    }

    public function deleteImage($id)
    {
        $sql = "UPDATE notes SET imagem = ? WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, "");
        $stmt->bindValue(2, $id);

        if ($stmt->execute()) {
            return "Imagem excluida com sucesso";
        } else {
            return "Erro ao excluir imagem";
        }
    }

    public function delete($id)
    {
        try {
            
            $resultado = $this->findId($id);

            $sql = "DELETE FROM notes WHERE id = ?";

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $id);

            if ($stmt->execute()) {

                if(!empty($resultado['imagem'])){
                    unlink("assets/img/".$resultado['imagem']);
                }

                return "Excluido com sucesso!";
            } else {
                return "Falha ao excluir";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
