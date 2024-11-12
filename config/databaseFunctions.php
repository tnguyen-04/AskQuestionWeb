<?php
function query($sql, $data = [])
{
    global $conn;
    try {
        $query = $conn->prepare($sql);
        if (empty($data)) {
            $query->execute();
        } else {
            $query->execute($data);
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
    return $query;
}

function insertData($tableName, $data)
{
    $keys = array_keys($data);
    $fields = implode(",", $keys);
    $values = ":" . implode(",:", $keys);
    $sql = "INSERT INTO `$tableName` ($fields) VALUES ($values)";
    query($sql, $data);
}

function updateData($tableName, $data, $condition = "")
{
    $setParts = [];
    foreach ($data as $key => $value) {
        $setParts[] = "`$key` = :$key";
    }
    $setString = implode(", ", $setParts);
    if (!empty($condition)) {
        $sql = "UPDATE `$tableName` SET $setString WHERE $condition";
    } else {
        $sql = "UPDATE `$tableName` SET $setString";
    }
    query($sql, $data);
}

function deleteData($tableName, $condition = "")
{
    if (!empty($condition)) {
        $sql = "DELETE FROM $tableName WHERE $condition";
    } else {
        $sql = "DELETE $tableName ";
    }
    query($sql);
}

function selectRows($sql)
{
    $query = query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function selectOneRow($sql)
{
    $query = query($sql);
    return $query->fetch(PDO::FETCH_ASSOC);
}
function totalRows($table)
{
    $sql = "SELECT COUNT(*) from $table";
    $query = query($sql);
    return $query->fetch(PDO::FETCH_ASSOC);
}
