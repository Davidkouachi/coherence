<!DOCTYPE html>
<html lang="zxx" class="js">
<!-- Mirrored from dashlite.net/demo8/invoice-print.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 15:18:16 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Invoice Print | DashLite Admin Template</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite0226.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme0226.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
</head>

<body class="bg-white" onload="printPromot()">
    <div class="nk-block">
        <div class="invoice invoice-print">
            <div class="invoice-wrap">
                <div class="invoice-brand text-center"><img src="images/logo.png" srcset="/demo8/images/logo-dark2x.png 2x" alt=""></div>
                <div class="invoice-head">
                    <div class="row g-gs">
                        <div class="col-md-12 col-xxl-12" id="groupesContainer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Type
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="Contentieux" readonly type="text" class="form-control" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Date
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="date" class="form-control" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Lieu
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Détecteur
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="detecteur }}" readonly type="text" class="form-control" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Non-conformité
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Conséquences
                                                </label>
                                                <div class="form-control-wrap">
                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Causes
                                                </label>
                                                <div class="form-control-wrap">
                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-bills">
                    <div class="row g-gs">
                        <div class="col-md-12 col-xxl-122" id="groupesContainer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-head">
                                        <h5 class="card-title">
                                            Action Corrective
                                        </h5>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Processus
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    risque
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Action
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Délai
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Date de realisation
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Date du Suivi
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <div class="form-control-wrap">
                                                    <input value="Action Réaliser" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <div class="form-control-wrap">
                                                    <input value="Action Non Réaliser" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Commentaire
                                                </label>
                                                <div class="form-control-wrap">
                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function printPromot() { window.print(); }

    </script>
</body>
<!-- Mirrored from dashlite.net/demo8/invoice-print.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 15:18:16 GMT -->

</html>
