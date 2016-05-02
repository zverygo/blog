<?php

function articles_all($link){
    //запрос
    $query = "SELECT * FROM articles ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    //извлечение из бд
    $n = mysqli_num_rows($result);
    $articles = array();
    
    for($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $articles[] = $row;
    }
    return $articles;
}

function articles_get($link, $id_article){
    //запрос
    $query = sprintf("SELECT * FROM articles WHERE id=%d",(int)$id_article);
    $result = mysqli_query($link, $query);
    
    if (!$result)
        die(mysqli_error($link));
    $article = mysqli_fetch_assoc($result);
    
    return $article;
}
//добавление новой статьи
function articles_new($link, $title, $date, $content){
    //подготовка
    $title = trim ($title); // убираем пробелы в начале и конце названия статьи
    $content = trim ($content);
    
    //проверка пустой ли заголовок статьи
    if ($title == '')
        return false;
    
    //запрос
    $t = "INSERT INTO articles (title, date, content) VALUES ('%s', '%s', '%s')";
    
    $query = sprintf ($t, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $date), mysqli_real_escape_string($link, $content)); // экранируем от SQL иньекций
    
    //echo $query; // выводит на страницу результат запраса, нахуя это было вставлять не понятно, разве что посмотреть как работает
    $result = mysqli_query ($link, $query);
    
    if (!$result)
        die(mysqli_error($link));
    
    return true;

}
//редактирование статьи
function articles_edit($link, $id, $title, $date, $content){
    //подготовка
    $title = trim ($title); // убираем пробелы в начале и конце названия статьи
    $content = trim ($content);
    $date = trim ($date);
    $id = (int)$id;
    
    //проверка пустой ли заголовок статьи
    if ($title == '')
        return false;
    
    //запрос
    $sql = "UPDATE articles SET title='%s', content='%s', date='%s' WHERE id='%d'";
    $query = sprintf ($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $content), mysqli_real_escape_string($link, $date), $id);
    $result = mysqli_query ($link, $query);
    if (!$result)
        die(mysqli_error($link));
    return mysqli_affected_rows ($link);
    
}
//удаление статьи
function articles_delete($link, $id){
    $id = (int)$id;
    //проверка
    if ($id == 0)
        return false;
    
    //запрос
    $query = sprintf ("DELETE FROM articles WHERE id='%d'", $id);
    $result = mysqli_query ($link, $query);
    if (!$result)
        die(mysqli_error($link));
    return mysqli_affected_rows ($link);
}
//выведение не полной статьи
function articles_intro ($text, $len = 250) {
    return mb_substr ($text, 0, $len);
}
    

?>