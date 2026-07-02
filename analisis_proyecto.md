# Análisis del Proyecto: **Smart Home**

El proyecto **Smart Home** es una plataforma web integrada diseñada para la gestión, el monitoreo en tiempo real, la automatización y el análisis inteligente de dispositivos de Internet de las Cosas (IoT) instalados en un hogar o edificio.

---

### 1. ¿Qué es lo que hace el proyecto?
El sistema centraliza la administración de múltiples dispositivos inteligentes de una vivienda. Permite:
*   **Monitorear el estado** (encendido/apagado, temperatura, etc.) y la ubicación de los dispositivos en tiempo real.
*   **Registrar el consumo energético** detallado (kWh, voltaje, corriente) de los dispositivos.
*   **Administrar alertas y eventos** generados por los sensores.
*   **Ejecutar automatizaciones lógicas** mediante reglas configuradas por el usuario.
*   **Generar análisis predictivos con Inteligencia Artificial** (utilizando GPT-4-turbo) para detectar anomalías, picos de consumo y dar recomendaciones de eficiencia energética en base al historial de la casa.
*   **Exportar reportes** de alertas a formato PDF.
*   **Interactuar con hardware real o simulado** a través del protocolo **MQTT** y endpoints HTTP (API).

---

### 2. ¿Para quién es? (Público Objetivo)
*   **Usuarios del Hogar (Smart Home Enthusiasts/Propietarios):** Personas interesadas en centralizar y controlar sus dispositivos inteligentes en un panel único y simplificado.
*   **Administradores de propiedades / Hotelería:** Profesionales que necesitan monitorear el consumo de energía y el estado de los aparatos en múltiples habitaciones, departamentos o instalaciones a distancia.
*   **Desarrolladores o Integradores de IoT:** Personas que desean una base personalizable e integrada con protocolos estándar (MQTT, Node-RED) con el poder añadido de un análisis IA para sus soluciones domóticas.

---

### 3. Problema que ataca
*   **Fragmentación de aplicaciones:** La domótica actual sufre de dispositivos de múltiples marcas que requieren diferentes aplicaciones para operar.
*   **Falta de analítica y entendimiento de datos:** Los dispositivos generan enormes cantidades de datos de consumo y eventos, pero los usuarios no suelen saber cómo interpretarlos ni cómo ahorrar energía.
*   **Automatización compleja:** Definir reglas inteligentes personalizadas suele requerir programar o lidiar con sistemas complejos de automatización.
*   **Ausencia de un registro histórico unificado:** Dificultad para rastrear cuándo ocurrieron fallos, picos de tensión, o anomalías de seguridad a lo largo del tiempo.

---

### 4. La solución que ofrece
*   **Panel de Control Centralizado (Dashboard):** Muestra el conteo de dispositivos, consumo total del día en kWh y alertas activas. Adicionalmente, incluye gráficos interactivos (creados con *Chart.js*) que desglosan las alertas diarias, niveles de riesgo (Info, Warning, Danger) y tipos de alertas.
*   **Gestión de Dispositivos (CRUD):** Registro de dispositivos especificando nombre, tipo (luces, enchufes, termostatos, sensores), protocolo de conexión (MQTT, HTTP, etc.) y ubicación física (sala, cocina, dormitorio), con opción de encendido/apagado remoto.
*   **Monitoreo de Consumos:** Mapeo de lecturas eléctricas (voltaje, corriente, consumo) por dispositivo.
*   **Reglas de Automatización:** Interfaz gráfica para crear reglas (Ej: *Si el "Sensor de Movimiento" registra un valor mayor a "1" a la hora "X", entonces "Encender" el dispositivo "Luz de Entrada"*).
*   **Notificaciones Inteligentes impulsadas por IA:** Un comando programado envía el historial de eventos recientes y métricas a OpenAI, devolviendo diagnósticos y recomendaciones de seguridad o ahorro de energía en formato de registros históricos amigables.
*   **Integración de Protocolos IoT (MQTT y HTTP):** Endpoints API para recibir datos y un servicio de escucha continuo (*MQTT Listener*) para procesar telemetría y enviar comandos bidireccionales en tiempo real.

---

### 5. Tech Stack Usado (Pila Tecnológica)
*   **Backend:** PHP 8.2+ junto con el framework **Laravel 12.0** para la estructura MVC, enrutamiento y API.
*   **Base de Datos:** Relacional (soporta SQLite/MySQL/PostgreSQL), gestionada con Laravel Migrations y **Eloquent ORM**.
*   **Autenticación y Perfiles:** **Laravel Breeze** para la gestión de usuarios, login, registro y edición de perfil con contraseña segura.
*   **Frontend & UI:**
    *   **Blade templates** (Motor de plantillas de Laravel).
    *   **Tailwind CSS** para un diseño moderno, responsivo y adaptado a modo oscuro.
    *   **Alpine.js** para interactividad ligera del lado del cliente.
    *   **Chart.js** para la renderización de los gráficos estadísticos en el dashboard.
*   **Integración de Inteligencia Artificial:** **OpenAI API** (Modelo `gpt-4-turbo`) para analizar los datos JSON y generar sugerencias proactivas de ahorro de energía y alertas críticas.
*   **Protocolos y Mensajería IoT:**
    *   **MQTT** mediante los paquetes `php-mqtt/client` y `bluerhinos/phpmqtt` para comunicación con brokers (como Mosquitto) e integraciones con Node-RED.
*   **Generación de Reportes:** **Barryvdh/Laravel-DomPDF** para exportar reportes descargables de alertas en formato PDF.
*   **Herramientas de Desarrollo:** **Vite** para compilar recursos frontend e integración concurrente en consola (`concurrently`) para correr el servidor web, cola de trabajos (queue listener) y el Vite dev server al mismo tiempo.

---

### 6. Estructura del Proyecto
Los archivos principales de la lógica de negocio se organizan de la siguiente manera dentro de la arquitectura de Laravel:

```bash
smart-home/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── AnalizarDatosIA.php   # Comando Artisan para enviar datos a OpenAI y guardar sugerencias
│   │       ├── MQTTListener.php      # Proceso en segundo plano para escuchar mensajes del broker MQTT
│   │       └── EmulateDevice.php     # Comando para simular el envío de datos de telemetría de un dispositivo
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php   # Procesa los datos clave e históricos para el Dashboard principal
│   │   │   ├── DeviceController.php      # Gestiona el CRUD y cambios de estado (Toggle) de los dispositivos
│   │   │   ├── AutomationController.php  # Controla la creación y ejecución de automatizaciones
│   │   │   ├── ConsumeController.php     # Muestra las métricas de consumo de energía por dispositivo
│   │   │   ├── AlertController.php       # Gestión y limpieza de alertas
│   │   │   ├── AlertReportController.php # Maneja la exportación de reportes PDF de alertas
│   │   │   └── MQTTController.php        # Acciones de prueba para publicar/suscribir MQTT
│   │   └── Api/
│   │       └── DeviceDataController.php  # Endpoint HTTP POST para que los sensores envíen sus datos
│   ├── Models/
│   │   ├── User.php                      # Usuario del sistema
│   │   ├── Device.php                    # Dispositivo IoT
│   │   ├── Consume.php                   # Lecturas de energía, voltaje y corriente
│   │   ├── Automation.php                # Reglas lógicas y horarios
│   │   ├── Alert.php                     # Incidencias y alertas registradas
│   │   └── Record.php                    # Bitácora e historial de eventos generales y de la IA
│   └── Services/
│       └── OpenAIService.php             # Lógica de conexión con la API de OpenAI y construcción de prompts
├── config/                               # Configuraciones de Laravel y servicios (servicios de OpenAI, etc.)
├── database/
│   └── migrations/                       # Esquemas de base de datos (creación de tablas y llaves foráneas)
├── resources/
│   └── views/                            # Vistas Blade del frontend
│       ├── dashboard.blade.php           # Interfaz del panel principal con gráficos Chart.js
│       ├── devices/                      # Vistas CRUD de dispositivos
│       ├── automations/                  # Creación y listado de automatizaciones
│       ├── alerts/                       # Listado de alertas
│       ├── consumes/                     # Gráficos y tablas de consumos
│       └── layouts/                      # Plantilla maestra de la aplicación
├── routes/
│   ├── web.php                           # Definición de rutas web, endpoints de exportación y la API interna
│   └── auth.php                          # Rutas de autenticación (Breeze)
├── composer.json                         # Dependencias PHP (Laravel, MQTT Client, DomPDF, etc.)
└── package.json                          # Dependencias Javascript/CSS (Tailwind, Vite, Alpine)
```
