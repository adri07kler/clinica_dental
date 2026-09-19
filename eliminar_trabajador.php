<?php
// TODO (equipo backend): sustituir este arreglo por una consulta real a la base de datos,
// por ejemplo: SELECT id, nombre, correo, rol FROM trabajadores;
$trabajadores = [
    ["id" => 1, "nombre" => "Adriana López", "correo" => "adriana@clinicadental.com", "rol" => "Administrador"],
    ["id" => 2, "nombre" => "Carlos Ramírez", "correo" => "carlos@clinicadental.com", "rol" => "Odontologo"],
    ["id" => 3, "nombre" => "Fernanda Ruiz", "correo" => "fernanda@clinicadental.com", "rol" => "Recepcion"],
];

// TODO (equipo backend): aquí se recibirá el resultado de la eliminación
// para mostrar mensaje de éxito o error, por ejemplo mediante $_GET.
$mensaje = $_GET['mensaje'] ?? '';
$tipo = $_GET['tipo'] ?? '';

function etiquetaRol($rol) {
    $etiquetas = [
        "Administrador" => "Administrador",
        "Odontologo" => "Odontólogo",
        "Recepcion" => "Recepción",
        "Asistente" => "Asistente"
    ];
    return $etiquetas[$rol] ?? $rol;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eliminar trabajador · Clínica Dental</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
  :root {
    --clinic-teal: #0f6b64;
    --clinic-teal-dark: #0a4b46;
    --clinic-mint: #e8f5f3;
    --clinic-ink: #142524;
    --clinic-line: #d8e6e4;
  }
  body {
    background: #f6faf9;
    color: var(--clinic-ink);
    font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
    min-height: 100vh;
  }
  .topbar { background: #fff; border-bottom: 1px solid var(--clinic-line); }
  .topbar a { color: var(--clinic-teal-dark); text-decoration: none; font-weight: 500; }
  .topbar a:hover { color: var(--clinic-teal); }
  .panel-card { background: #fff; border: 1px solid var(--clinic-line); border-radius: 12px; }
  .table > :not(caption) > * > * { padding: 0.9rem 0.8rem; vertical-align: middle; }
  thead.table-head { background: var(--clinic-mint); }
  thead.table-head th { font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.06em; color: var(--clinic-teal-dark); font-weight: 600; border-bottom: none; }
  .role-badge { font-size: 0.76rem; padding: 0.32rem 0.6rem; border-radius: 6px; font-weight: 600; }
  .role-Administrador { background: #fdecea; color: #a33328; }
  .role-Odontologo { background: #e8f5f3; color: #0f6b64; }
  .role-Recepcion { background: #eef1fb; color: #3a4ba0; }
  .role-Asistente { background: #fff6e5; color: #8a5a00; }
  .avatar-circle { width: 36px; height: 36px; border-radius: 50%; background: var(--clinic-mint); color: var(--clinic-teal-dark); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; flex-shrink: 0; }
  .empty-state { padding: 3rem 1rem; text-align: center; color: #6b8b87; }
</style>
</head>
<body>

<div class="topbar px-3 px-md-4 py-3">
  <a href="trabajadores.php"><i class="bi bi-arrow-left me-1"></i> Volver a Trabajadores</a>
</div>

<div class="p-3 p-md-5">
  <div class="mb-3">
    <h5 class="mb-0">Eliminar trabajador</h5>
    <small class="text-muted">Selecciona al trabajador que deseas dar de baja del sistema</small>
  </div>

  <?php if ($mensaje): ?>
    <div class="alert alert-<?= $tipo === 'exito' ? 'success' : 'danger' ?>">
      <i class="bi bi-<?= $tipo === 'exito' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?> me-1"></i>
      <?= htmlspecialchars($mensaje) ?>
    </div>
  <?php endif; ?>

  <div class="panel-card">
    <div class="table-responsive">
      <table class="table mb-0">
        <thead class="table-head">
          <tr>
            <th>Trabajador</th>
            <th>Correo</th>
            <th>Rol</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($trabajadores) === 0): ?>
            <tr>
              <td colspan="4">
                <div class="empty-state">
                  <i class="bi bi-people fs-2 d-block mb-2"></i>
                  No hay trabajadores registrados.
                </div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($trabajadores as $t): ?>
              <?php
                $iniciales = "";
                foreach (array_slice(explode(" ", $t["nombre"]), 0, 2) as $palabra) {
                    $iniciales .= strtoupper($palabra[0]);
                }
              ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="avatar-circle"><?= $iniciales ?></div>
                    <span><?= htmlspecialchars($t["nombre"]) ?></span>
                  </div>
                </td>
                <td class="text-muted"><?= htmlspecialchars($t["correo"]) ?></td>
                <td>
                  <span class="role-badge role-<?= $t["rol"] ?>"><?= etiquetaRol($t["rol"]) ?></span>
                </td>
                <td class="text-end">
                  <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar"
                          data-bs-toggle="modal" data-bs-target="#modalEliminar"
                          data-id="<?= $t["id"] ?>" data-nombre="<?= htmlspecialchars($t["nombre"]) ?>">
                    <i class="bi bi-trash3"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--
        TODO (equipo backend): este formulario envía por POST a eliminar_proceso.php,
        que aún no existe. Ahí se debe validar el id, conectar a la BD y eliminar el registro.
      -->
      <form action="eliminar_proceso.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar trabajador</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          ¿Seguro que quieres eliminar a <strong id="nombreAEliminar"></strong> del sistema? Esta acción no se puede deshacer.
          <input type="hidden" name="id" id="idAEliminar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
  // Solo pasa el id y nombre del trabajador seleccionado al modal de confirmación
  document.querySelectorAll(".btn-eliminar").forEach(btn => {
    btn.addEventListener("click", () => {
      document.getElementById("idAEliminar").value = btn.dataset.id;
      document.getElementById("nombreAEliminar").textContent = btn.dataset.nombre;
    });
  });
</script>
</body>
</html>