<?php

function getname($qry, $myemail) {
  $stmt = $qry->prepare("SELECT names FROM user WHERE email =:email");
  $stmt->bindValue(':email', $myemail);
  $stmt->execute();
  $name = $stmt->fetchColumn();
  return $name;
}

function getrole($qry, $myemail) {
  $stmt = $qry->prepare("SELECT role FROM user WHERE email =:email");
  $stmt->bindValue(':email', $myemail);
  $stmt->execute();
  $role = $stmt->fetchColumn();
  return $role;
}

function configured($qry, $id) {
  $stmt = $qry->prepare("SELECT configured FROM test WHERE id =:id");
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  $state = $stmt->fetchColumn();
  return $state;
}
function completed($qry, $id) {
  $stmt = $qry->prepare("SELECT complete FROM complete WHERE course =:id");
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  $state = $stmt->fetchColumn();
  return $state;
}
function get_range($qry, $id) {
  $stmt = $qry->prepare("SELECT points FROM test WHERE id =:id");
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  $state = $stmt->fetchColumn();
  return $state;
}

function getcourse($db, $myemail) {
  $stmt = $db->prepare("SELECT courseid FROM course WHERE LecturerEmail =:email LIMIT 1");
  $stmt->bindValue(':email', $myemail);
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}

function get_title($db) {
  $sql3 = "SELECT title from marks";
  $query3 = $db->prepare($sql3);
  $query3->execute();
  $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
  return $results3;
}

// New function to count components
function get_component_count($db, $email, $course_id) {
  $stmt = $db->prepare("SELECT COUNT(title) FROM marks 
                         WHERE course = :course_id AND email = :email
                          ");
  $stmt->bindValue(':course_id', $course_id);
  $stmt->bindValue(':email', $email);
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}
function get_mark_count($db,$cid,$title) {
  $stmt = $db->prepare("SELECT COUNT(`$title`)  FROM $cid");
                          
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}
function get_student_count($db,$cid) {
  $stmt = $db->prepare("SELECT COUNT(reg) AS mark_count FROM $cid 
                          ");
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}
function get_test($db,$cid) {
  $stmt = $db->prepare("SELECT COUNT(title) AS mark_count FROM marks WHERE course = $cid
                          ");
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}


?>