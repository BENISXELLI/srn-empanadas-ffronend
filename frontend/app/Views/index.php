<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empanadas</title>
    <style>
        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 80%; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        button { margin-right: 5px; }


    /* Modal: fondo semitransparente */
        .modal {
            display: none;
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
            transition: background 0.3s, transform 0.2s;
        }
        .btn-cerrar:hover { 
            background-color: #d32f2f; 
            transform: scale(1.05);
        }

        .btn-agregar {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            flex: 1;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-agregar:hover { 
            background-color: #45a049; 
            transform: scale(1.05);
        }


        /* Botones de la tabla: Editar */
        .btn-agregar-inicio {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            flex: 1;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-agregar-inicio:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
        
        /* Botones de la tabla: Editar */

        table button.edit {
            background-color: #2196f3;  /* azul */
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s, transform 0.2s;
        }

        table button.edit:hover {
            background-color: #1976d2;
            transform: scale(1.05);
        }

        /* Botones de la tabla: Eliminar */
        table button.delete {
            background-color: #f44336;  /* rojo */
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s, transform 0.2s;
        }

        table button.delete:hover {
            background-color: #d32f2f;
            transform: scale(1.05);
        }   

        #toast {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4caf50;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.8s ease;
        }
    </style>
</head>
<body>
<h1 style="display: block; margin: 0 auto; text-align: center">Gestión de Empanadas</h1>
<h2>Agregar Empanada</h2>
    <!-- Botón para abrir el modal -->
<button class="btn-agregar-inicio" id="btnAbrirModal">Agregar Empanada</button>
<br>
<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-contenido">
        <span class="cerrar">&times;</span>
        <h2 style="display: block; text-align: center">Agregar Empanada</h2>
        <form id="form-agregar">
            <input type="hidden" id="empanada-id" readonly>
            <label for="name">Nombre de la empanada:</label>
            <input type="text" id="name" required>
            <label for="type">Tipo de empanada:</label>
            <select id="type" name="type" required>
                <option value="">-- Seleccionar el tipo de empanada --</option>
                <option value="Horno">Horno</option>
                <option value="Frita">Frita</option>
            </select>
            <label for="filling">Relleno / Descripción:</label>
            <textarea id="filling" name="filling" rows="4" placeholder="Ej: Carne molida, cebolla..." required></textarea>
            <label for="price">Precio:</label>
            <input type="number" id="price" step="0.01" required>
            <!-- Select de disponibilidad solo visible en edición -->
            <div id="grupo-disponible" style="display:none;">
                <label for="is_sold_out">Disponibilidad:</label>
                <select id="is_sold_out" name="is_sold_out">
                    <option value="0">Disponible</option>
                    <option value="1">Agotado</option>
                </select>
            </div>
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
                <td>${e.name}</td>
                <td>${e.type}</td>
                <td>${e.filling}</td>
                <td>$${e.price}</td>
                <td>${e.is_sold_out ? "Agotado" : "Disponible"}
                </td>
                <td>
                    <button class="edit" onclick="editarEmpanada(${e.id}, '${e.name.replace(/'/g,"\\'")}', '${e.type}', ${e.price}, '${e.filling.replace(/'/g,"\\'")}', ${e.is_sold_out})">Editar</button>
                    <button class="delete" onclick="eliminarEmpanada(${e.id})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

        // Agregar empanada
    document.getElementById("form-agregar").addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = empanadaId.value;
        const data = {
            name: document.getElementById("name").value,
            type: document.getElementById("type").value,
            filling: document.getElementById("filling").value,
            price: parseFloat(document.getElementById("price").value),
        };
        //console.log(id);
        if (id) {
            //console.log('editar');
            // En edición, incluir disponibilidad
            data.is_sold_out = document.getElementById("is_sold_out").value;
            await fetch(`${API_URL}/empanada/${id}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
            mostrarToast("✏️ Empanada actualizada");
        } else {
            //console.log('agregar');
            await fetch(`${API_URL}/empanada`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
            mostrarToast("✅ Empanada agregada");
        }
        modal.style.display = "none";
        cargarEmpanadas();
        e.target.reset();
    });

    // Editar empanada
    async function editarEmpanada(id, name, type, price, filling, is_sold_out) {
        modal.style.display = "flex";
        modalTitle.innerText = "Editar Empanada";
        document.getElementById("grupo-disponible").style.display = "block";
        empanadaId.value = id;
        document.getElementById("name").value = name;
        document.getElementById("type").value = type;
        document.getElementById("filling").value = filling;
        document.getElementById("price").value = price;
        document.getElementById("is_sold_out").value = is_sold_out;
        document.querySelector(".btn-agregar").innerText = "Actualizar";
    }

    // Eliminar empanada
    async function eliminarEmpanada(id) {
        const confirmar = confirm("⚠️ ¿Estás seguro que deseas eliminar esta empanada en la lista? ⚠️");
        if (!confirmar){ 
            return; 
        } else {
            await fetch(`${API_URL}/empanada/${id}`, { method: "DELETE" });
            cargarEmpanadas();
            mostrarToast("🗑️ Empanada eliminada"); 
        }
    }

    // Cargar al inicio
    cargarEmpanadas();

    const modal = document.getElementById("modal");
    const btnAbrirModal = document.getElementById("btnAbrirModal");
    const spanCerrar = document.querySelector(".cerrar");
    const btnCerrarModal = document.querySelector(".btn-cerrar");
    const formEmpanada = document.getElementById("form-agregar");
    const empanadaId = document.getElementById("empanada-id");
    const modalTitle = document.querySelector("#modal h2");


    btnAbrirModal.onclick = () => {
        modal.style.display = "flex";
        modalTitle.innerText = "Agregar Empanada";
        formEmpanada.reset();
        empanadaId.value = "";
        document.getElementById("grupo-disponible").style.display = "none";
        document.querySelector(".btn-agregar").innerText = "Agregar";
    };
    // Cerrar modal
    spanCerrar.onclick = btnCerrarModal.onclick = () => modal.style.display = "none";
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