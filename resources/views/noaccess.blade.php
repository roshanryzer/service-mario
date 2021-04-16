<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Title -->
    <title>No access</title>
    <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon') }}">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('main/vendor/bootstrap4/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/font-awesome/css/font-awesome.min.css')}}">
    <style type="text/css">
        body {
            background: white;
        }

        h2 {

            color: #48208E;
            -webkit-background-clip: text;
            background-clip: text;
        }

        .errorhead {
            margin-top: 55px;
        }

        .errorhead h2 {
            text-align: center;
            font-size: 40vh;
        }

        .errorhead p {
            text-align: center;
            font-size: 30px;
        }

        .perm {
            font-size: 22px !important;
        }

        .backhome {
            border: none;
            background: #48208E;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 20px;
            border-radius: 100px;
        }

        .fuller {
            text-align: center;
        }

        .fa {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container-fluid fuller">
    <div class="errorhead ">
        <h2> 403 </h2>
        <p> Access Denied or Prohibited! </p>
        <p class="perm"> You do not have permission to access this page </p></div>
    <a href="" class="text-center">
        <button class="backhome" onclick="history.back();" style="cursor: pointer;"><i class="fa fa-home"></i>Back to
            Home
        </button>
    </a>
</div>
</body>
</html>


<!DOCTYPE html>
<html>
<head></head>
<body>
<table style="margin: 0 auto; width: 95%; padding: 15px; border: 1px solid #ddd; font-size: 13px; font-family: Arial;"
       data-mce-style="margin: 0 auto; width: 95%; padding: 15px; border: 1px solid #ddd; font-size: 13px; font-family: Arial;"
       class="mceItemTable" align="center">
    <tbody>
    <tr>
        <td align="center">
            <table style="width: 100%;" data-mce-style="width: 100%;" class="mceItemTable" cellspacing="0"
                   cellpadding="0" border="0" align="center">
                <tbody>
                <tr>
                    <td>
                        <table style="width: 100%; text-align: justify; font-size: 12px;"
                               data-mce-style="width: 100%; text-align: justify; font-size: 12px;" class="mceItemTable">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="font-family: Arial; font-size: 12px; font-weight: 600;"
                                       data-mce-style="font-family: Arial; font-size: 12px; font-weight: 600;">Dear
                                        @@User_Name,</p>
                                    <p>This is to inform you that a "Monthly Closing" request has been
                                        initiated.&nbsp;</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="border: 1px solid #ddd; width: 100%; font-family: Arial; font-size: 12px;"
                               data-mce-style="border: 1px solid #ddd; width: 100%; font-family: Arial; font-size: 12px;"
                               class="mceItemTable">
                            <tbody>
                            <tr>
                                <td style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;"
                                    data-mce-style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;">
                                    <b>Requester Name</b>
                                </td>
                                <td style="font-size: 12px;" data-mce-style="font-size: 12px;">
                                    <span>@=Requestor_Employee_Name</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;"
                                    data-mce-style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;">
                                    <b>
                                        <b>Department Name</b>
                                    </b>
                                </td>
                                <td style="font-size: 12px;" data-mce-style="font-size: 12px;">
                                    @=Requestor_Employee_Department
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;"
                                    data-mce-style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;">
                                    Designation
                                </td>
                                <td style="font-size: 12px;" data-mce-style="font-size: 12px;">
                                    @=Requestor_Employee_Designation
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;"
                                    data-mce-style="background-color: #f2f6f1; width: 20%; font-weight: 600; font-size: 12px;">
                                    For Month
                                </td>
                                <td style="font-size: 12px;" data-mce-style="font-size: 12px;">
                                    @=Requestor_Employee_Designation
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%; text-align: justify;" data-mce-style="width: 100%; text-align: justify;"
                   class="mceItemTable">
                <tbody>
                <tr>
                    <td>
                        <p>CLICK HERE TO
                            <a href="@=Case_Link" data-mce-href="@=Case_Link">OPEN</a> THIS REQUEST.
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr></tr>
    </tbody>
</table>
<p>
    <br data-mce-bogus="1">
</p>
</body>
</html>
