<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <style>
        /* Estilos CSS (sin cambios) */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        header {
            padding: 20px 0;
            border-bottom: 3px solid #007bff;
            margin-bottom: 20px;
        }

        header h1 {
            color: #007bff;
            font-weight: 600;
            margin: 0;
            font-size: 2em;
        }

        .role-selector {
            display: flex;
            align-items: flex-end;
            padding: 15px;
            border-radius: 8px;
            background-color: #e3f2fd;
            margin-bottom: 30px;
            gap: 20px;
        }

        .role-selector>div {
            flex-grow: 1;
        }

        .role-selector label {
            font-weight: 600;
            color: #0056b3;
        }

        select {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #007bff;
            border-radius: 4px;
            font-size: 1em;
            background-color: #fff;
        }

        .module-tabs {
            display: flex;
            border-bottom: 2px solid #ccc;
            margin-bottom: 20px;
        }

        .tab-button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background: transparent;
            font-weight: 600;
            color: #666;
            transition: color 0.2s, border-bottom 0.2s;
            border-radius: 4px 4px 0 0;
        }

        .tab-button.active {
            color: #007bff;
            border-bottom: 3px solid #007bff;
            background-color: #f0f8ff;
        }

        .tab-content {
            padding: 20px 0;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
        }

        .section-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #007bff;
        }

        .section-card h3 {
            color: #333;
            font-size: 1.2em;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .section-card p.req {
            font-style: italic;
            color: #555;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        input[type="number"],
        input[type="text"],
        input[type="date"] {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 5px;
        }

        button.secondary {
            background-color: #6c757d;
        }

        button:hover {
            background-color: #0056b3;
        }

        .btn-group {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #response_container {
            margin-top: 40px;
        }

        #response_container h2 {
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        #response_output {
            background: #272c35;
            color: #f0f0f0;
            padding: 15px;
            border-radius: 6px;
            white-space: pre-wrap;
            overflow-x: auto;
            min-height: 100px;
            font-family: monospace;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="role-selector">
            <div>
                <label for="current_user_select"></label>
                <select id="current_user_select">
                    <option value=""></option>
                </select>
            </div>

        </div>

        <div class="module-tabs">
            <button class="tab-button active" onclick="openTab(event, 'ModuloEmpleado')">Módulo Empleado</button>
            <button class="tab-button" onclick="openTab(event, 'ModuloJefe')">Módulo Jefe</button>
            <button class="tab-button" onclick="openTab(event, 'ModuloRRHH')">Módulo RRHH/Admin</button>
        </div>

        <div id="ModuloEmpleado" class="tab-content">
            <h2>Gestión de Ausencias y Perfil Personal</h2>
            <div class="action-grid">

                <div class="section-card">
                    <h3>Solicitar y Consultar Vacaciones</h3>
                    <p class="req">El empleado debe poder solicitar días de vacaciones.</p>
                    <label for="e_start_date">Fecha Inicio:</label>
                    <input type="date" id="e_start_date" value="2026-07-01">
                    <label for="e_end_date">Fecha Fin:</label>
                    <input type="date" id="e_end_date" value="2026-07-03">
                    <label for="e_dias_solicitados">Días:</label>
                    <input type="number" id="e_dias_solicitados" value="3" min="1" required>
                    <div class="btn-group">
                        <button onclick="solicitarVacaciones()">Enviar Solicitud</button>
                        <button onclick="consultarSaldo()">Consultar Saldo</button>
                        <button onclick="revisarEstatus()">Revisar Estatus de Solicitudes</button>
                    </div>
                </div>

                <div class="section-card">
                    <h3>Consulta de Expediente</h3>
                    <p class="req">El empleado debe poder ver su perfil y documentos.</p>
                    <div class="btn-group">
                        <button onclick="listarMisDocumentos()">Ver Expediente Digital</button>
                    </div>
                    <p class="req" style="margin-top: 20px;">El empleado debe poder revisar sus datos personales.</p>
                    <div class="btn-group">
                        <button onclick="listarMiPerfil()">Ver Mi Perfil</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="ModuloJefe" class="tab-content" style="display:none">
            <h2>Aprobación y Monitoreo de Equipo</h2>
            <div class="action-grid">

                <div class="section-card">
                    <h3>Gestión de Solicitudes</h3>
                    <p class="req">R. Funcional: El jefe debe poder aprobar o rechazar solicitudes de su equipo.</p>
                    <label for="j_solicitud_select">Seleccione Solicitud Pendiente:</label>
                    <select id="j_solicitud_select">
                        <option value="">Cargando datos automáticamente...</option>
                    </select>

                    <div class="btn-group">
                        <button onclick="listarPendientes()">Actualizar Lista de Pendientes</button>
                        <button onclick="aprobarSolicitud()">Aprobar</button>
                        <button onclick="rechazarSolicitud()" class="secondary">Rechazar</button>
                    </div>
                </div>

                <div class="section-card">
                    <h3>Reportes de Equipo</h3>
                    <p class="req">El jefe debe poder ver un resumen de ausencias de su equipo.</p>
                    <div class="btn-group">
                        <button onclick="consultarReporteJefe()">Ver Reporte de Ausentismo</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="ModuloRRHH" class="tab-content" style="display:none">
            <h2>Administración Central y Nómina</h2>
            <div class="action-grid">

                <div class="section-card">
                    <h3>Gestión de Empleados</h3>
                    <p class="req">RRHH debe poder dar de alta nuevos empleados.</p>
                    <label>Nombre/Puesto:</label>
                    <input type="text" id="r_nombre_new" value="Nuevo Tester HR">
                    <input type="text" id="r_email_new" value="tester@rrhh.com">

                    <div class="btn-group">
                        <button onclick="altaEmpleado()">Dar de Alta </button>
                        <button onclick="listarEmpleados()" class="secondary">Listado General de Empleados</button>
                    </div>
                </div>

                <div class="section-card">
                    <h3>Gestión de Documentos y Nómina</h3>
                    <p class="req">RRHH debe poder registrar documentos en el expediente.</p>
                    <label for="r_doc_empleado_select">Seleccione Empleado para Documento:</label>
                    <select id="r_doc_empleado_select">
                        <option value="">Cargando datos automáticamente...</option>
                    </select>

                    <div class="btn-group">
                        <button onclick="cargarDocumento()">Registrar Contrato</button>
                        <button onclick="incidenciasNomina()" class="secondary">Consulta de Incidencias Nómina</button>
                    </div>
                </div>

            </div>
        </div>


        <div id="response_container">
            <h2>Respuesta del Servidor/Gateway</h2>
            <pre id="response_output">Cargando datos iniciales de los microservicios...</pre>
        </div>

    </div>
    <script>
        let allEmployees = [];
        let allPendingRequests = [];
        const output = document.getElementById('response_output');
        const BASE_PATH = window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')) + '/';

        class HttpRequestFactory {
            static createRequest(method, url, body = null) {
                const headers = {
                    'Content-Type': 'application/json'
                };
                const options = {
                    method,
                    headers
                };

                if (body && (method === 'POST' || method === 'PUT')) {
                    options.body = JSON.stringify(body);
                }

                return {
                    url,
                    options
                };
            }

            static createGetRequest(url) {
                return HttpRequestFactory.createRequest('GET', url);
            }

            static createPostRequest(url, data) {
                return HttpRequestFactory.createRequest('POST', url, data);
            }

            static createPutRequest(url, data = null) {
                return HttpRequestFactory.createRequest('PUT', url, data);
            }
        }

        function showResponse(data, status = 'OK') {
            output.textContent = `Status: ${status}\n\n${JSON.stringify(data, null, 2)}`;
        }
        async function fetchAPI(url, method = 'GET', body = null) {

            let request;
            if (method === 'GET') {
                request = HttpRequestFactory.createGetRequest(url);
            } else if (method === 'POST') {
                request = HttpRequestFactory.createPostRequest(url, body);
            } else if (method === 'PUT') {
                request = HttpRequestFactory.createPutRequest(url, body);
            } else {
                return showResponse({
                    error: "Método HTTP no soportado por la Fábrica Abstracta."
                }, 405);
            }

            if (url.indexOf('listado') === -1 && url.indexOf('pendientes') === -1) {
                output.textContent = `Cargando... [${request.options.method}] Petición a: ${request.url}`;
            }

            try {
                const fullUrl = BASE_PATH + 'microservicios/' + request.url;
                const response = await fetch(fullUrl, request.options);

                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error(`Respuesta no es JSON. Verifique la URL y los logs de PHP: ${text}`);
                }

                if (!response.ok) {
                    showResponse(data, `ERROR ${response.status} (${response.statusText})`);
                    return null;
                }

                if (url.indexOf('listado') === -1 && url.indexOf('pendientes') === -1) {
                    showResponse(data, response.status);
                }
                return data;
            } catch (error) {
                showResponse({
                    error: "Error en la petición o en el servidor.",
                    details: error.message
                }, 'ERROR 500');
                return null;
            }
        }

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-button");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function populateSelect(selectId, dataArray, idKey, displayKey, secondaryKey = null) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">-- Seleccione --</option>';

            if (dataArray && dataArray.length > 0) {
                dataArray.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item[idKey];
                    let text = `${item[idKey]} - ${item[displayKey]}`;
                    if (secondaryKey) {
                        text += ` (${item[secondaryKey]})`;
                    }
                    option.textContent = text;
                    select.appendChild(option);
                });
            } else {
                select.innerHTML = '<option value="">No hay datos disponibles...</option>';
            }
        }

        async function loadUserSessionSelect() {
            const select = document.getElementById('current_user_select');
            select.innerHTML = '<option value="">Cargando usuarios...</option>';

            const empleadosUrl = `ms-perfiles/api_perfiles.php?action=listado`;
            const empleados = await fetchAPI(empleadosUrl, 'GET');

            if (empleados) {
                allEmployees = empleados;

                select.innerHTML = '';
                empleados.forEach(emp => {
                    const option = document.createElement('option');
                    option.value = emp.id_empleado;
                    option.textContent = `${emp.id_empleado} - ${emp.nombre} (${emp.puesto})`;
                    select.appendChild(option);
                });
                select.value = '104';
            } else {
                select.innerHTML = '<option value="">Error al cargar usuarios</option>';
            }
            return true;
        }


        async function loadInitialData() {
            output.textContent = 'Cargando datos maestros y solicitudes pendientes...';

            if (allEmployees.length === 0) {
                await loadUserSessionSelect();
            }


            const pendientesUrl = `ms-ausencias/api_ausencias.php?action=pendientes`;
            allPendingRequests = await fetchAPI(pendientesUrl, 'GET');

            if (!allEmployees || allEmployees.length === 0) {
                output.textContent = 'ERROR: No se pudieron cargar los datos de los EMPLEADOS (MS-Perfiles). El select de solicitudes no mostrará nombres.';
                allEmployees = [];
            }

            if (!allPendingRequests || allPendingRequests.length === 0) {

                output.textContent += '\n\n ÉXITO: No hay solicitudes pendientes actualmente en el sistema.';
                populateSelect('j_solicitud_select', [], 'id_solicitud', 'display_text');
                return true;
            }

            if (allEmployees && allPendingRequests) {

                const employeeMap = allEmployees.reduce((map, emp) => {
                    map[emp.id_empleado] = emp.nombre;
                    return map;
                }, {});

                const pendingRequestsWithNames = allPendingRequests.map(req => {
                    const employeeName = employeeMap[req.id_empleado] || `ID: ${req.id_empleado} (Nombre Desconocido)`;
                    return {
                        id_solicitud: req.id_solicitud,
                        fecha_inicio: req.fecha_inicio,
                        display_text: `${req.fecha_inicio} - ${req.dias_solicitados} días (por ${employeeName})`,
                        id_empleado: req.id_empleado
                    };
                });


                populateSelect('r_doc_empleado_select', allEmployees, 'id_empleado', 'nombre');
                populateSelect('j_solicitud_select', pendingRequestsWithNames, 'id_solicitud', 'display_text');

                output.textContent = `✅ Datos maestros cargados. Se encontraron ${allPendingRequests.length} solicitudes pendientes.`;
            } else {
                output.textContent += '\n\n❌ Fallo crítico en la orquestación. Revise los logs del Gateway.';
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', async () => {
            document.querySelector('.tab-button').click();
            await loadUserSessionSelect();
            await loadInitialData(); 
        });

        async function consultarSaldo() {
            const id = document.getElementById('current_user_select').value;
            const url = `ms-ausencias/api_ausencias.php?action=saldo&id_empleado=${id}`;
            await fetchAPI(url, 'GET');
        }

        async function solicitarVacaciones() {
            const id = document.getElementById('current_user_select').value;
            const fecha_inicio = document.getElementById('e_start_date').value;
            const fecha_fin = document.getElementById('e_end_date').value;
            const dias_solicitados = parseInt(document.getElementById('e_dias_solicitados').value);

            const url = `ms-ausencias/api_ausencias.php?action=solicitar`;
            const data = {
                id_empleado: id,
                fecha_inicio,
                fecha_fin,
                dias_solicitados
            };
            await fetchAPI(url, 'POST', data);
        }

        async function revisarEstatus() {
            const id = document.getElementById('current_user_select').value;
            const url = `ms-ausencias/api_ausencias.php?action=estatus&id_empleado=${id}`;
            await fetchAPI(url, 'GET');
        }

        async function listarMiPerfil() {
            const id = document.getElementById('current_user_select').value;
            const url = `ms-perfiles/api_perfiles.php?action=listado`;
            const result = await fetchAPI(url, 'GET');
            if (result) {
                const miPerfil = result.find(p => String(p.id_empleado) === id);
                showResponse({
                    mensaje: "Perfil filtrado localmente del listado general.",
                    perfil: miPerfil
                }, 200);
            }
        }

        async function listarMisDocumentos() {
            const id = document.getElementById('current_user_select').value;
            const url = `ms-documentos/api_documentos.php?action=incidencias_diarias&fecha=${new Date().toISOString().slice(0, 10)}`;
            const result = await fetchAPI(url, 'GET');
            if (result) {
                const misIncidencias = result.filter(i => String(i.id_empleado) === id);
                showResponse({
                    mensaje: "Documentos simulados (Incidencias del día) filtrados.",
                    incidencias: misIncidencias
                }, 200);
            }
        }

        async function listarPendientes() {
            await loadInitialData();
        }

        async function aprobarSolicitud() {
            const id = document.getElementById('j_solicitud_select').value;
            const aprobador_id = document.getElementById('id_aprobador_manual').value;
            if (!id || !aprobador_id) return showResponse({
                error: "Seleccione una solicitud y un ID de aprobador."
            }, 400);

            const url = `ms-ausencias/api_ausencias.php?action=aprobar&id_solicitud=${id}&id_aprobador=${aprobador_id}`;
            const result = await fetchAPI(url, 'PUT');

            if (result) loadInitialData();
        }

        async function rechazarSolicitud() {
            const id = document.getElementById('j_solicitud_select').value;
            const aprobador_id = document.getElementById('id_aprobador_manual').value;
            if (!id || !aprobador_id) return showResponse({
                error: "Seleccione una solicitud y un ID de aprobador."
            }, 400);

            const url = `ms-ausencias/api_ausencias.php?action=rechazar&id_solicitud=${id}&id_aprobador=${aprobador_id}`;
            const data = {
                motivo_rechazo: 'Rechazo del jefe por conflicto de fechas.'
            };
            const result = await fetchAPI(url, 'PUT', data);

            if (result) loadInitialData();
        }

        async function consultarReporteJefe() {
            const url = `ms-documentos/api_documentos.php?action=reporte_ausentismo&mes=2025-09-01&id_departamento=2`;
            await fetchAPI(url, 'GET');
        }

        async function altaEmpleado() {
            const url = `ms-perfiles/api_perfiles.php?action=alta`;
            const data = {
                nombre: document.getElementById('r_nombre_new').value,
                puesto: "HR Specialist",
                email: document.getElementById('r_email_new').value + Date.now().toString().substring(8),
                fecha_ingreso: new Date().toISOString().slice(0, 10),
                id_jefe: 103,
                id_departamento: 3
            };
            const result = await fetchAPI(url, 'POST', data);

            if (result) loadInitialData();
        }

        async function listarEmpleados() {
            const url = `ms-perfiles/api_perfiles.php?action=listado`;
            await fetchAPI(url, 'GET');
        }

        async function cargarDocumento() {
            const id = document.getElementById('r_doc_empleado_select').value;
            if (!id) return showResponse({
                error: "Seleccione un empleado para cargar el documento."
            }, 400);

            const url = `ms-documentos/api_documentos.php?action=cargar_documento&id_empleado=${id}`;
            const data = {
                nombre_documento: `Contrato ${new Date().getFullYear()}`
            };
            await fetchAPI(url, 'POST', data);
        }

        async function incidenciasNomina() {
            const today = new Date().toISOString().slice(0, 10);
            const url = `ms-documentos/api_documentos.php?action=incidencias_diarias&fecha=${today}`;
            await fetchAPI(url, 'GET');
        }
    </script>
</body>

</html>