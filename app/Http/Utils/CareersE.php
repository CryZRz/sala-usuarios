<?php

namespace App\Http\Utils;

enum CareersE: string {
    case ISC = "Ingenieria en Sistemas Computacionales";
    case IGE = "Ingenieria en Gestion Empresarial";
    case IEM = "Ingenieria en Electromecanica";
    case ILG = "Ingenieria en Logistica";
    case IIN = "Ingenieria en Industrial";
    case ITICS = "Ingeniería en TICS";

    public static function getCareers(): array {
        return array_map(fn($item) => $item->value, CareersE::cases());
    }
}