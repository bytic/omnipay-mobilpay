<?php

declare(strict_types=1);

return json_decode(
    json_encode(
        [
            "order" => [
                "id" => "1663430766",
                "description" => "desc",
                "amount" => 10.5,
                "currency" => "RON",
                "billing" => [
                    "country" => "",
                    "county" => "",
                    "city" => "",
                    "address" => " ",
                    "postal_code" => "",
                    "first_name" => "Gabriel",
                    "last_name" => "Solomon",
                    "phone" => null,
                    "email" => "solomongaby@yahoo.com",
                ],
                "shipping" => null,
                "installments" => null,
                "installments_sel" => null,
                "bonuspoints" => null,
                "products" => [
                    "item" => [
                        "id" => null,
                        "name" => null,
                        "description" => null,
                        "info" => null,
                        "group" => null,
                        "amount" => null,
                        "currency" => null,
                        "quantity" => null,
                        "vat" => null,
                    ],
                ],
                "recurrence" => null,
                "int_id" => null,
            ],
            "errors" => [
                "action" => "",
                "code" => "48",
                "message" => "gwInvalidRequest",
                "details" => [
                    "item" => [
                        "message" => "Camp obligatoriu",
                        "code" => "billing/phone",
                    ],
                ],
            ],
        ]
    )
);