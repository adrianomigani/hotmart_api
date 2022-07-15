<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>WEBHOOK iOKR - Adriano Migani</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script>
    function sendRequest() {
        $.post("webhook-hotmart.php", {
                transaction: "02010101010",
                status: "approved",
                email: "xxx@xxx.com",
                first_name: "José",
                last_name: "da silva",
                prod: "1752615",
                phone_checkout_number: "991558520",
                phone_checkout_local_code: "16",
                name_subscription_plan: "Plano Avançado",
                doc: "20811282090",

            },
            function(data) {
                if (data) {
                    alert(data);
                }
            }

        )
    }
    </script>
</head>

<body>
    <button onclick="sendRequest()">Send Request</button>
</body>

</html>