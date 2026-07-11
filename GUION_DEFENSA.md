<h1 align="center">🎤 Guión para la Defensa del Servicio Comunitario</h1>
<h3 align="center">Sistema de Gestión de Matrícula Escolar — E.B.M.J. "San Francisco"</h3>

<p align="center"><em>Guía de presentación dividida en cuatro (4) partes, una por cada integrante del equipo.</em></p>

---

## 📌 Recomendaciones generales antes de comenzar

- **Duración sugerida:** entre 3 y 5 minutos por estudiante (15–20 minutos en total).
- **Tono:** hablar con seguridad, mirar al jurado y evitar leer palabra por palabra. Este
  guión es una **guía**, no un texto para memorizar de forma rígida.
- **Coordinación:** cada estudiante debe presentar y **"pasar la palabra"** al siguiente
  compañero al terminar su parte.
- **Material de apoyo:** tener el sistema **abierto y funcionando** (en XAMPP) y, si es
  posible, una lámina o presentación con los puntos clave.
- **Antes de iniciar:** verificar que Apache y MySQL estén encendidos y que el login abra
  correctamente en `http://localhost/registro_san_francisco/login.php`.

---

# 1️⃣ Primer Estudiante — Apertura y Presentación del Proyecto

> 🎯 **Objetivo de esta parte:** dar la bienvenida, presentar al equipo y explicar **qué es**
> el proyecto, **qué problema resuelve** y **cuáles son sus objetivos**.

### Puntos que debe cubrir

**a) Saludo y presentación del equipo**
- Saludar formalmente al jurado y a los presentes.
- Presentar al grupo (indicar que son un equipo de cuatro integrantes) y mencionar la
  institución y la carrera.

**b) Presentación del proyecto**
- Explicar que el proyecto de servicio comunitario consistió en desarrollar un
  **Sistema de Gestión de Matrícula Escolar** para la E.B.M.J. **"San Francisco"**,
  ubicada en Barquisimeto, estado Lara.

**c) El problema que se detectó**
- La escuela realizaba las inscripciones de forma **manual, en planillas de papel**.
- Esto ocasionaba: demoras en la atención, riesgo de **pérdida o deterioro** de las
  planillas, dificultad para **buscar** un estudiante y posibilidad de **errores** o
  registros duplicados.

**d) La solución propuesta**
- Un sistema web que **digitaliza** la ficha de inscripción y guarda todo de forma
  **ordenada, centralizada y segura** en una base de datos.

**e) Objetivos del proyecto**
- **Objetivo general:** automatizar el proceso de inscripción y control de matrícula de la
  escuela.
- **Objetivos específicos:** sustituir el papel por una ficha digital, almacenar la
  información de forma segura, permitir consultas rápidas y proteger el acceso con usuarios.

### 💬 Ejemplo de cómo iniciar

> *"Muy buenos días, respetados miembros del jurado. Somos un equipo de cuatro estudiantes
> y hoy presentamos nuestro proyecto de servicio comunitario, que consistió en el desarrollo
> de un Sistema de Gestión de Matrícula Escolar para la Escuela Básica San Francisco, aquí en
> Barquisimeto. Detectamos que la escuela inscribía a sus estudiantes a mano, en papel, lo
> que generaba demoras y riesgo de perder la información. Por eso, nuestro objetivo fue..."*

### ➡️ Cierre de la parte
> *"A continuación, mi compañero(a) explicará el trabajo técnico que realizamos y cómo
> funciona el sistema por dentro."*

---

# 2️⃣ Segundo Estudiante — Desarrollo Técnico y Trabajo Realizado

> 🎯 **Objetivo de esta parte:** explicar **el trabajo realizado durante las horas de
> servicio comunitario** y **cómo funciona internamente** el sistema (su parte técnica).

### Puntos que debe cubrir

**a) El proceso de trabajo (las horas de servicio)**
- Explicar las fases que llevó el proyecto:
  1. **Diagnóstico** de la necesidad en la escuela.
  2. **Diseño** de la base de datos y de las pantallas.
  3. **Programación** de los módulos.
  4. **Pruebas** con datos reales de la institución.

**b) ¿Qué hace el sistema? (los módulos)**
- **Control de acceso (login):** solo el personal autorizado entra al sistema.
- **Dashboard de estadísticas:** muestra de forma automática los números y gráficos de la
  matrícula (total de estudiantes, por grado, por turno y por sexo).
- **Ficha de inscripción:** un formulario dividido en tres secciones — datos del
  **estudiante**, datos del **representante** e **historial académico** (grado, turno, fecha).
- **Guardado seguro:** valida que no exista un estudiante con la misma cédula antes de
  registrar.
- **Consulta:** muestra en una tabla todos los estudiantes inscritos, con un buscador.
- **Gestión de usuarios:** permite cambiar la contraseña de acceso.

**c) La base de datos (el corazón del sistema)**
- Explicar que toda la información se guarda en una base de datos llamada
  `escuelasanfrancisco`, formada por **cuatro tablas** relacionadas:
  - `usuarios` → cuentas de acceso.
  - `representantes` → datos del padre/madre/representante.
  - `estudiantes` → datos del alumno.
  - `historial_academico` → datos de la inscripción.
- Aclarar la relación: **un representante puede tener varios estudiantes**, y **cada
  estudiante tiene su historial académico**.

**d) La seguridad**
- Se usaron **consultas preparadas** para evitar ataques a la base de datos
  (inyección SQL).
- El sistema **no deja entrar** a ninguna pantalla sin haber iniciado sesión.
- Se **validan los datos** para no repetir cédulas.

### 💬 Ejemplo de frase de apoyo

> *"Durante nuestras horas de servicio comunitario, primero diagnosticamos la necesidad,
> luego diseñamos la base de datos y programamos cada módulo. El sistema funciona con cuatro
> tablas relacionadas: una para los usuarios, una para los representantes, una para los
> estudiantes y otra para el historial académico. Además, aplicamos medidas de seguridad
> como las consultas preparadas, que protegen la información de la escuela."*

### ➡️ Cierre de la parte
> *"Ahora, mi compañero(a) les mostrará el sistema por dentro y las tecnologías que
> utilizamos para construirlo."*

---

# 3️⃣ Tercer Estudiante — Recorrido por el Sistema y Tecnologías Utilizadas

> 🎯 **Objetivo de esta parte:** hacer un **recorrido visual** por el sistema y explicar
> **con qué tecnologías** fue construido.

### Puntos que debe cubrir

**a) Recorrido por las pantallas** *(mostrándolas en vivo o con capturas)*
1. **Pantalla de acceso (login):** aquí se escribe el usuario y la contraseña.
2. **Menú principal:** desde aquí se accede a todas las funciones.
3. **Dashboard de estadísticas:** mostrar los indicadores (total de estudiantes,
   representantes, becados, etc.) y los gráficos por grado, turno y sexo. Resaltar que
   **se actualizan automáticamente** con cada inscripción.
4. **Ficha de inscripción:** mostrar las tres secciones del formulario (estudiante,
   representante e historial académico).
5. **Lista de estudiantes:** mostrar cómo el sistema presenta a todos los inscritos en una
   tabla ordenada, con el **buscador en vivo** y las etiquetas de color.
6. **Gestión de usuarios:** mostrar la opción para cambiar la contraseña.

**b) Tecnologías utilizadas y por qué**

| Tecnología | ¿Para qué se usó? |
|------------|-------------------|
| **PHP** | Es el lenguaje que procesa los formularios y se comunica con la base de datos. |
| **MySQL / MariaDB** | Es la base de datos donde se guarda toda la información de forma permanente. |
| **HTML5** | Da la estructura a las páginas y a los formularios. |
| **CSS3** | Da el diseño, los colores institucionales y la apariencia profesional. |
| **XAMPP (Apache)** | Es el servidor local que permite ejecutar el sistema. |
| **phpMyAdmin** | Herramienta para administrar la base de datos de forma visual. |

**c) Por qué se eligieron estas tecnologías**
- Son **gratuitas y de libre acceso**, lo que hace el proyecto sostenible para la escuela.
- Son **ampliamente utilizadas** y fáciles de mantener.
- Funcionan en **cualquier computadora** con XAMPP instalado, sin necesidad de internet.

### 💬 Ejemplo de frase de apoyo

> *"Como pueden observar, esta es la pantalla de inicio de sesión. Al entrar, llegamos al
> menú principal, desde donde accedemos a la ficha de inscripción, que está dividida en tres
> partes... Para construir todo esto utilizamos PHP para la programación, MySQL para la base
> de datos, y HTML y CSS para el diseño. Elegimos estas tecnologías porque son gratuitas y
> funcionan sin necesidad de internet."*

### ➡️ Cierre de la parte
> *"Para finalizar, mi compañero(a) realizará una demostración en vivo del sistema y
> presentará nuestras conclusiones."*

---

# 4️⃣ Cuarto Estudiante — Demostración en Vivo y Cierre

> 🎯 **Objetivo de esta parte:** realizar una **demostración práctica** del sistema
> funcionando y **cerrar** la presentación con las conclusiones.

### Puntos que debe cubrir

**a) Demostración en vivo (parte demostrativa)** — *el momento más importante*
- **Inscribir un estudiante de prueba** de principio a fin:
  1. Iniciar sesión con el usuario `admin`.
  2. Entrar a **"Inscribir Nuevo Estudiante"**.
  3. Llenar la ficha con datos de ejemplo.
  4. Guardar y mostrar el mensaje de **"¡Inscripción Guardada con Éxito!"**.
- **Consultar** el registro recién creado en **"Ver Registros de Estudiantes"** para
  demostrar que la información quedó guardada (y usar el **buscador** para encontrarlo).
- **Abrir el Dashboard** y mostrar cómo el **contador de estudiantes aumentó** y los
  gráficos se actualizaron solos tras la nueva inscripción. *(Este es un momento de gran
  impacto visual ante el jurado.)*
- *(Opcional)* Mostrar la **validación**: intentar registrar la misma cédula otra vez y
  enseñar cómo el sistema **impide el duplicado**.

> 💡 **Consejo:** tener los datos de prueba listos y escritos en un papel para no perder
> tiempo ni ponerse nervioso durante la demostración.

**b) Resultados y beneficios para la escuela**
- Se logró un sistema **funcional** que digitaliza las inscripciones.
- **Ahorro de papel** y de tiempo en la atención.
- La información queda **segura y organizada**, fácil de consultar.
- El personal puede **buscar cualquier estudiante en segundos**.

**c) Conclusiones**
- El proyecto cumplió con el objetivo de **automatizar el proceso de matrícula**.
- Aplicamos los conocimientos de la carrera para **resolver una necesidad real** de la
  comunidad.

**d) Recomendaciones / mejoras futuras** *(opcional, suma puntos)*
- Agregar la opción de **imprimir la ficha o generar constancias en PDF**.
- Permitir **editar** o **eliminar** registros desde el sistema.
- Ampliar el **dashboard** con más reportes (por ejemplo, alumnos con Canaima o por
  parroquia) y la opción de **exportar** las estadísticas.

**e) Agradecimiento y cierre**
- Agradecer a la escuela, al jurado y al público.
- Ofrecerse a responder preguntas.

### 💬 Ejemplo de cierre

> *"Para demostrar que el sistema funciona, voy a inscribir un estudiante en este momento...
> Como pueden ver, el sistema guardó la información y aquí aparece el registro en la lista.
> En conclusión, logramos digitalizar el proceso de inscripción de la escuela, ahorrando
> papel y tiempo, y dejando la información segura y organizada. Agradecemos su atención y con
> gusto responderemos sus preguntas."*

---

## ✅ Lista de verificación final (checklist del equipo)

- [ ] XAMPP encendido (Apache + MySQL).
- [ ] Base de datos `escuelasanfrancisco` importada.
- [ ] Login probado y funcionando (`admin` / `6789`).
- [ ] Dashboard mostrando datos (revisar que haya estudiantes cargados).
- [ ] Datos de prueba preparados para la demostración.
- [ ] Cada estudiante conoce su parte y sabe a quién le pasa la palabra.
- [ ] Lámina o presentación de apoyo lista (opcional).

---

<p align="center"><strong>¡Éxito en la defensa! 🎓</strong></p>
