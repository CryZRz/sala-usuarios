<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sala de usuarios</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    @vite(['resources/scss/app.scss',
            'resources/scss/incidence/create.scss',
            'resources/js/incidence/createIncidence.js'
    ])
</head>
<body>
<main class="w-full vh-100 row g-0">
    <section id="loading-container"></section>
    <section class="section-left-container col-lg-7 col-md-7 col-sm-12">

    </section>
    <section class="col-lg-5 col-md-5 col-sm-12 h-full section-right-container">
        <div class="w-full d-flex justify-content-center align-items-center">
            <div class="login-container rounded col-12">
                <section class="login-header">
                    <div class="profile-image-container d-flex justify-content-center">
                        <img src="./images/logoITL.png" alt="tecnm logo">
                    </div>
                    <div class="mt-2">
                        <label class="col-12 text-white" for="control-number">Numero de control</label>
                        <div class="d-flex col-12">
                            <input
                                class="border-0 rounded-start-2 p-1 col-10"
                                type="text"
                                name="control-number"
                                id="control-number"
                                required
                            >
                            <button class="rounded-end-2 border-0 btn-find-student col-2" id="btn-find-student">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </section>
                <section class="login-body d-flex flex-column justify-content-center ">
                    <div>
                        <h3>Alumno:</h3>
                    </div>
                    <div>
                        <form
                            class="d-flex flex-column"
                            action="{{route("incidence.store")}}"
                            method="post"
                            id="form-create-incidence"
                        >
                            @csrf
                            <input type="hidden" name="controlNumber" id="control-number-hidden">
                            <div class="d-flex mb-2">
                                <div class="">
                                    <label class="col-12" for="name">Nombres:</label>
                                    <input
                                        class="col-12 input-info"
                                        name="name"
                                        type="text"
                                        disabled
                                        id="name-student-input"
                                    >
                                </div>
                                <div class="">
                                    <label class="col-12" for="last-name">Apellidos:</label>
                                    <input
                                        class="col-12 input-info"
                                        name="last-name"
                                        type="text"
                                        disabled
                                        id="last-name-student-input"
                                    >
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="col-12" for="career">Carrera:</label>
                                <input
                                    class="col-12 input-info"
                                    type="text"
                                    name="career"
                                    id="career-student-input"
                                    disabled
                                >
                            </div>
                            <div class="mb-2">
                                <label class="col-12" for="semester">Semestre:</label>
                                <input
                                    class="col-12 input-info"
                                    type="text"
                                    name="semester"
                                    id="semester-student-input"
                                    disabled
                                >
                            </div>
                            <div>
                                <label class="col-12" for="description">Descripción:</label>
                                <textarea
                                    class="col-12 input-info"
                                    name="description"
                                    disabled
                                    id="description-student-input"
                                    required
                                ></textarea>
                            </div>
                            <div class="mt-2 col-12">
                                <button class="rounded col-12 btn-create-incidence">
                                    Registrar incidencia
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>
</body>
</html>
