<?php

switch ($_SERVER['CONTENT_TYPE']) {
    case 'application/json':
        $json = json_decode(file_get_contents('php://input'));
        break;
    case 'application/x-www-form-urlencoded':
        $json = json_decode($_POST['payload']);
        break;
    default:
        throw new \Exception("Unsupported content type: $_SERVER[CONTENT_TYPE]");
}

$data = $json->repository->full_name;
if($data=="debent/debent.org"){
    $data = $json->head_commit->message;
    // if (strpos(strtolower($data), 'release') !== false) {
    // }
    $data = shell_exec('whoami');
    file_put_contents('log_other.txt',$data, FILE_APPEND | LOCK_EX);
    $data = shell_exec('pwd');
    file_put_contents('log_other.txt',$data, FILE_APPEND | LOCK_EX);
    $data = shell_exec('gitpull');
    file_put_contents('log_other.txt',$data, FILE_APPEND | LOCK_EX);
    echo "debEnt Website Updated";
}

?>