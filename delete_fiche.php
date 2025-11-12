<?php
include __DIR__ . '/Config/config.php';

if (isset($_POST['id'])) {
  $id = intval($_POST['id']);
  $stmt = $conn->prepare("DELETE FROM fiches WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo "success";
  } else {
    echo "error";
  }

  $stmt->close();
} else {
  echo "invalid";
}
?>
