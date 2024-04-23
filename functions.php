<?php
session_start();

$today = date("Y-m-d");
$connect = mysqli_connect("localhost", "root", "", "ukk_perpus_bintang");

function query($query)
{
    global $connect;

    $query_result = mysqli_query($connect, $query);

    return $query_result;
}

function fetch($query)
{
    return mysqli_fetch_array($query);
}

function rows($query)
{
    return mysqli_num_rows($query);
}

function Qselect($table, $data)
{
    $query_result = query("SELECT * FROM " . $table . " " . $data);

    return $query_result;
}

function ifset($data)
{
    return isset($_POST[$data]);
}

function finn($data)
{
    return htmlspecialchars(trim($_POST[$data]));
}

function post($data)
{
    return $_POST[$data];
}

function Qinsert($table, $data)
{
    $query_result = query("INSERT INTO " . $table . " SET " . $data);

    return $query_result;
}

function Qupdate($table, $data, $where)
{
    $query_result = query("UPDATE " . $table . " SET " . $data . " WHERE id_" . $table . "=" . $where);

    return $query_result;
}

function Qdisable($table, $where)
{
    $query_result = query("UPDATE " . $table . " SET disable='1' WHERE id_" . $table . "=" . $where);

    return $query_result;
}

function swalert($text)
{
    echo "<script>alert('" . $text . "');</script>";
}

function valid($data)
{
    return ($data == '' || empty($data));
}

function myData($data) {
    return $_SESSION['perpus_bintang'][$data];
}