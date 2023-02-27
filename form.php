<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="form.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Globoticket</title>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto ms-3 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <img src="logo.png" alt="Globoticket logo" />
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Registration Form</h1>
        <?php
        // htmlspecialchars scrubs the data and ent quotes is a set of data you want to remove from the data you are passing in example ^&&*
        // if(isset($_POST["submit"]) && $_POST["submit"] === "Register") {
            $formComplete = false;

            $email = htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES);
            $password = htmlspecialchars($_POST["password"] ?? "", ENT_QUOTES);
            $comments = htmlspecialchars($_POST["comments"] ?? "", ENT_QUOTES);
            $customertype = htmlspecialchars($_POST["customertype"] ?? "", ENT_QUOTES);
            $tos = htmlspecialchars($_POST["tos"] ?? "", ENT_QUOTES);
            $layout = htmlspecialchars($_POST["layout"] ?? "", ENT_QUOTES);
            $interests = (isset($_POST["interests"]) && is_array($_POST["interests"])) ? 
                htmlspecialchars(implode(", ", $_POST["interests"]), ENT_QUOTES) :
                "";
           
            if (isset($_POST["submit"]) && $_POST["submit"] === "Register") {
        
            //implode takes values from the array and glue them together to a string, between those values we will use a comma and a blank
            $formComplete = true;
            $errorMessages = [];
  
            // if (trim($email) === "" || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            //     $formComplete = false;
            // }

            if (trim($email) === "") {
                $formComplete = false;
                array_push($errorMessages, "Email address missing");
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $formComplete = false;
                array_push($errorMessages, "Email address is incorrect");
            }

            if (trim($password) === "") {
                $formComplete = false;
                array_push($errorMessages, "Passoword field cannot be blank");
            }
            if (trim($comments) === "") {
                $formComplete = false;
                array_push($errorMessages, "Comments missing");
            }
            if (!in_array($customertype, ["seller", "buyer"])) {
                $formComplete = false;
                array_push($errorMessages, "Customer type missing");
            }
            if ($tos !== "ok") {
                $formComplete = false;
                array_push($errorMessages, "ToS must be accepted");
            }
            if (!in_array($layout, ["dark", "light"])) {
                $formComplete = false;
                array_push($errorMessages, "Layout selection missing");
            }
            if ($interests === "") {
                $formComplete = false;
                array_push($errorMessages, "Interests missing");
            }

            if ($formComplete) {
                echo "<div class=\"mb-3\">Email: $email<br>Password: $password
                <br>Customer type: $customertype<br>Accept TOS: $tos
                <br>Layout: $layout<br>Interests: $interests<br>
                Comments: " . nl2br($comments) ."</div>";
            } else {
                echo "<div class=\"mt-4 mb-3 text-danger\"><p class=\"fw-bold\">Validation errors:</p><ul>";
                foreach ($errorMessages as $errorMessage) {
                echo "<li>$errorMessage</li>";
            }
                echo "</ul></div>";
            }
        };

        if (!$formComplete) {
            ?>
            <form method="post" action="" class="mt-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" name="email" id="email" value="<?=$email?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="layout" class="form-label">Layout</label>
                    <select name="layout" id="layout" class="form-select">
                        <option value="">-- Please choose --</option>
                        <option value="dark">Dark</option>
                        <option value="light">Light</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="interests" class="form-label">Interests</label>
                    <select multiple size="3" name="interests[]" id="interests" class="form-select">
                        <option value="1">Concerts</option>
                        <option value="2">Sports</option>
                        <option value="3">Theater</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <label class="form-label me-5">Customer type</label>
                    <div class="mb-3 me-4 form-check">
                    <input type="radio" name="customertype" value="seller" id="seller" class="form-check-input">
                        <label class="form-check-label" for="seller">Seller</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="radio" name="customertype" value="buyer" id="buyer" class="form-check-input">
                        <label class="form-check-label" for="buyer">Buyer</label>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="tos" value="ok" id="tos" class="form-check-input">
                    <label class="form-check-label" for="tos">Accept TOS</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="comments">Comments</label>
                    <textarea name="comments" id="comments" class="form-control"><?=$comments?>
                    </textarea>
                </div>
                <!-- <input type="submit" name="submit" value="Register" class="btn btn-primary"> -->
                <input type="submit" name="submit" value="Register" class="btn btn-primary">
            </form>
            <?php
        }
        ?>
    </div>
</body>

</html>