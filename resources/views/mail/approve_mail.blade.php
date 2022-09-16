<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NoPrice |Approval </title>
    <style>
        .pt-2 {
            padding-top: 0.5rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 1320px;
            }
        }

        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1140px;
            }
        }

        @media (min-width: 992px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm {
                max-width: 960px;
            }
        }

        @media (min-width: 768px) {

            .container,
            .container-md,
            .container-sm {
                max-width: 720px;
            }
        }

        @media (min-width: 576px) {

            .container,
            .container-sm {
                max-width: 540px;
            }
        }

        .container,
        .container-fluid,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl,
        .container-xxl {
            width: 100%;
            padding-right: var(--bs-gutter-x, .75rem);
            padding-left: var(--bs-gutter-x, .75rem);
            margin-right: auto;
            margin-left: auto;
        }

        div {
            display: block;
        }

        body {
            margin: 0;
            font-family: var(--bs-body-font-family);
            font-size: var(--bs-body-font-size);
            font-weight: var(--bs-body-font-weight);
            line-height: var(--bs-body-line-height);
            color: var(--bs-body-color);
            text-align: var(--bs-body-text-align);
            background-color: var(--bs-body-bg);
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
        }

        .rounded {
            border-radius: 0.25rem !important;
        }

        .bg-white {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-white-rgb), var(--bs-bg-opacity)) !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .shadow {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        .text-center {
            text-align: center !important;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .card-title {
            margin-bottom: 0.5rem;
        }

        .text-muted {
            --bs-text-opacity: 1;
            color: #6c757d !important;
        }

        .pb-2 {
            padding-bottom: 0.5rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .card-subtitle {
            margin-top: -0.25rem;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container pt-2 mt-2 justify-content-center">
        <div class="card-container">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body text-center">
                    <h2 class="card-title">No Price</h2>
                    <h4 class="card-subtitle mb-2 text-muted pb-2">{{$mailData['body']}}</h4>
                </div>
            </div>
        </div>
    </div>

</body>

</html>