<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function is_logged() { return !empty($_SESSION['user_id']); }
function get_logged_user_id() { return $_SESSION['user_id'] ?? null; }

function get_logged_user($mysqli) {
    $id = get_logged_user_id();
    if (!$id) return null;
    $sql = "SELECT u.id_usuarios, u.nm_usuario, p.img_perfil
            FROM tb_usuarios u
            LEFT JOIN tb_perfil p ON p.tb_usuarios_id_usuarios = u.id_usuarios
            WHERE u.id_usuarios = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();
        return $user ?: null;
    }
    return null;
}
?>
