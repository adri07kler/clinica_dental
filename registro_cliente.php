<?php
// TODO (equipo backend): aquí se recibirá el resultado del registro
// para mostrar mensaje de éxito o error, por ejemplo mediante $_GET.
$mensaje = $_GET['mensaje'] ?? '';
$tipo = $_GET['tipo'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar cliente · Clínica Dental</title>
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
  .form-card { background: #fff; border: 1px solid var(--clinic-line); border-radius: 14px; max-width: 680px; }
  .form-card .card-header-custom { background: var(--clinic-mint); border-bottom: 1px solid var(--clinic-line); border-radius: 14px 14px 0 0; padding: 1.25rem 1.5rem; }
  .form-card .card-header-custom h5 { color: var(--clinic-teal-dark); margin-bottom: 2px; }
  .btn-clinic { background: var(--clinic-teal); border-color: var(--clinic-teal); color: #fff; }
  .btn-clinic:hover { background: var(--clinic-teal-dark); border-color: var(--clinic-teal-dark); color: #fff; }
  .form-label { font-weight: 500; font-size: 0.92rem; }
  .section-title { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--clinic-teal-dark); font-weight: 600; margin-bottom: 0.75rem; margin-top: 1.5rem; }
  #inputCurp { text-transform: uppercase; }
</style>
</head>
<body>

<div class="topbar px-3 px-md-4 py-3">
  <a href="clientes.php"><i class="bi bi-arrow-left me-1"></i> Volver a Clientes</a>
</div>

<div class="d-flex justify-content-center p-3 p-md-5">
  <div class="form-card w-100">
    <div class="card-header-custom">
      <h5>Registrar cliente</h5>
      <small class="text-muted">Completa los datos para agregarlo al sistema</small>
    </div>

    <div class="card-body p-4">

      <?php if ($mensaje): ?>
        <div class="alert alert-<?= $tipo === 'exito' ? 'success' : 'danger' ?>">
          <i class="bi bi-<?= $tipo === 'exito' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?> me-1"></i>
          <?= htmlspecialchars($mensaje) ?>
        </div>
      <?php endif; ?>

      <!--
        TODO (equipo backend): este formulario envía por POST a procesar_registro_cliente.php,
        que aún no existe. Ahí se debe validar, conectar a la BD e insertar el registro.
      -->
      <form action="procesar_registro_cliente.php" method="POST" novalidate>

        <div class="section-title">Identificación</div>
        <div class="mb-3">
          <label class="form-label" for="inputCurp">CURP</label>
          <input type="text" class="form-control" id="inputCurp" name="curp"
                 placeholder="Ej. GOMC990101HDFNRL05"
                 maxlength="18" minlength="18"
                 pattern="^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$"
                 title="La CURP debe tener 18 caracteres con el formato oficial"
                 required>
          <div class="form-text">18 caracteres, tal como aparece en el documento oficial.</div>
        </div>

        <div class="section-title">Datos generales</div>
        <div class="row">
          <div class="col-md-8 mb-3">
            <label class="form-label" for="inputNombre">Nombre completo</label>
            <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="Ej. María González Pérez" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label" for="inputFechaNacimiento">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="inputFechaNacimiento" name="fecha_nacimiento" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="inputSexo">Sexo</label>
            <select class="form-select" id="inputSexo" name="sexo" required>
              <option value="" disabled selected>Selecciona una opción</option>
              <option value="F">Femenino</option>
              <option value="M">Masculino</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="inputTelefono">Teléfono</label>
            <input type="tel" class="form-control" id="inputTelefono" name="telefono"
                   placeholder="Ej. 5512345678" pattern="^\d{10}$"
                   title="10 dígitos, sin espacios ni guiones" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="inputCorreo">Correo electrónico</label>
          <input type="email" class="form-control" id="inputCorreo" name="correo" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="mb-4">
          <label class="form-label" for="inputDireccion">Dirección</label>
          <textarea class="form-control" id="inputDireccion" name="direccion" rows="2" placeholder="Calle, número, colonia, ciudad" required></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="clientes.php" class="btn btn-outline-secondary">Cancelar</a>
          <button type="submit" class="btn btn-clinic">
            <i class="bi bi-person-plus-fill me-1"></i> Registrar
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
  // Fuerza mayúsculas en la CURP mientras se escribe (el patrón de validación las exige)
  document.getElementById("inputCurp").addEventListener("input", (e) => {
    e.target.value = e.target.value.toUpperCase();
  });
</script>
</body>
</html>