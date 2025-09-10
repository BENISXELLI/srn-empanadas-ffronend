<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empanadas</title>
    <style>

        /* Modal: fondo semitransparente */
.modal {
  display: none; /* oculto por defecto */
  position: fixed;
  z-index: 10000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
}

/* Contenido del modal */
.modal-contenido {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  position: relative;
}

/* Botón cerrar */
.cerrar {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

input, select, textarea {
  width: 100%;
  padding: 10px 12px;
  margin: 8px 0 16px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
  box-sizing: border-box;
}

.modal-botones {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.btn-cerrar {
    background-color: #f44336;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    flex: 1;
    transition: background 0.3s;
}
.btn-cerrar:hover {
    background-color: #d32f2f;
}

.btn-agregar {
    flex: 1;
}


        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 60%; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        button { margin-right: 5px; }

        #toast {
  display: none;
  position: fixed;
   top: 20px;       /* desde la parte superior */
  right: 20px;     /* desde la derecha */
  background: #4caf50;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  font-weight: bold;
  box-shadow: 0 4px 8px rgba(0,0,0,0.3);
  z-index: 9999;

  opacity: 0; /* oculto por defecto */
  transition: opacity 0.8s ease; /* animación suave */
}
    </style>
</head>
<body>
    <h1>Gestión de Empanadas</h1>
    <h2>Agregar Empanada</h2>
    <!-- Botón para abrir el modal -->
<button id="btnAbrirModal">Agregar Empanada</button>

<!-- Modal -->
<div id="modal" class="modal">
  <div class="modal-contenido">
    <span class="cerrar">&times;</span>
    <h2>Agregar Empanada</h2>
    <form id="form-agregar">
        <label for="name">Nombre de la empanada:</label>
        <input type="text" id="name" required>
        <label for="type">Tipo de empanada:</label>
        <select id="type" name="type" required>
            <option value="">-- Seleccionar el tipo de empanada --</option>
            <option value="Horno">Horno</option>
            <option value="Frita">Frita</option>
        </select>
        <label for="filling">Relleno / Descripción de la empanada:</label>
        <textarea id="filling" name="filling" rows="4" placeholder="Ej: Carne molida, cebolla, huevo duro..." required></textarea>
        <label for="price">Precio de la empanada:</label>
        <input type="number" id="price" placeholder="Precio" step="0.01" required>
        <div class="modal-botones">
            <button type="submit" class="btn-agregar">Agregar</button>
            <button type="button" class="btn-cerrar">Cerrar</button>
        </div>
    </form>
  </div>
</div>


    <h2>Listado de Empanada</h2>

    <table id="tabla-empanadas">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Contenido</th>
                <th>Precio</th>
                <th>Disponible</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div id="toast"></div>

    <script>
        const API_URL = "http://localhost:3000/api"; // la ruta del backend Node.js

        // Cargar lista de empanadas
        async function cargarEmpanadas() {
            const res = await fetch(`${API_URL}/empanadas`);
            const data = await res.json();
            const tbody = document.querySelector("#tabla-empanadas tbody");
            tbody.innerHTML = "";

            data.forEach(e => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${e.id}</td>
                    <td>${e.name}</td>
                    <td>${e.type}</td>
                    <td>${e.filling}</td>
                    <td>$${e.price}</td>
                    <td>${e.is_sold_out ? "Agotado" : "Disponible"}
                    </td>
                    
                    <td>
                        <button onclick="editarEmpanada(${e.id}, '${e.name}', '${e.type}', ${e.price})">Editar</button>
                        <button onclick="eliminarEmpanada(${e.id})">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Agregar empanada
        document.getElementById("form-agregar").addEventListener("submit", async (e) => {
            e.preventDefault();
            const nueva = {
                name: document.getElementById("name").value,
                type: document.getElementById("type").value,
                filling: document.getElementById("filling").value,
                price: parseFloat(document.getElementById("price").value),
            };
            await fetch(`${API_URL}/empanada`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(nueva)
            });
            mostrarToast("✅ Se ha agregado una empanada a la lista");
            modal.style.display = "none";
            cargarEmpanadas();
            e.target.reset();
        });

        // Eliminar empanada
        async function eliminarEmpanada(id) {

            const confirmar = confirm("⚠️ ¿Estás seguro que deseas eliminar esta empanada en la lista?");
                if (!confirmar) return; // si cancela, no hace nada

    await fetch(`${API_URL}/empanada/${id}`, { method: "DELETE" });
    cargarEmpanadas();
    mostrarToast("🗑️ Empanada eliminada"); // opcional: mensaje de confirmación
        }

        // Editar empanada
        async function editarEmpanada(id, name, type, price) {
            const nuevoNombre = prompt("Nuevo nombre:", name);
            if (!nuevoNombre) return;
            await fetch(`${API_URL}/empanada/${id}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ name: nuevoNombre, type, price })
            });
            mostrarToast("✅ Se ha actualizado los datos de empanada");
            cargarEmpanadas();
        }

        // Cargar al inicio
        cargarEmpanadas();


// Abrir modal
const modal = document.getElementById("modal");
const btnAbrirModal = document.getElementById("btnAbrirModal");
const spanCerrar = document.querySelector(".cerrar");
const btnCerrarModal = document.querySelector(".btn-cerrar");


btnAbrirModal.onclick = () => { modal.style.display = "flex"; }
spanCerrar.onclick = () => { modal.style.display = "none"; }
btnCerrarModal.onclick = () => { modal.style.display = "none"; }

// Cerrar modal al hacer clic fuera del contenido
window.onclick = (e) => {
  if(e.target == modal) modal.style.display = "none";
}

        function mostrarToast(mensaje) {
  const toast = document.getElementById("toast");
  toast.textContent = mensaje;
  toast.style.display = "block";

  // fade in
  setTimeout(() => {
    toast.style.opacity = "1";
  }, 10);

  // fade out después de 3s
  setTimeout(() => {
    toast.style.opacity = "0";
    // ocultar después de la animación
    setTimeout(() => {
      toast.style.display = "none";
    }, 800);
  }, 3000);
}

    </script>
</body>
</html>