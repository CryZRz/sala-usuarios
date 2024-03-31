<?php

namespace App\Http\Utils;

enum CareersE: string
{
    case ISC = "Ingeniería en Sistemas Computacionales";
    case IGE = "Ingeniería en Gestión Empresarial";
    case IEM = "Ingeniería en Electromecánica";
    case ILG = "Ingeniería en Logística";
    case IIN = "Ingeniería Industrial";
    case ITICS = "Ingeniería en Tecnologías de la Información y Comunicaciones";
    case MCC = "Maestría en Ciencias de la Computación";
    case MCI = "Maestría en Ciencias de la Ingeniería";
    case IE = "Ingeniería Electrónica";
    case IM = "Ingeniería Mecatrónica";

    public static function getCareers(): array
    {
        return array_map(fn($item) => $item->value, CareersE::cases());
    }
}
