<?php
namespace App\Core;

interface ModelInterface
{
    public function getAll();
    public function getById($id);
}