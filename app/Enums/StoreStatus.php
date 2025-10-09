<?php

namespace App\Enums;

enum StoreStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
}

// Enum digunakan untuk mendefinisikan daftar nilai tetap (konstan) yang valid.
// Di sini StoreStatus hanya bisa bernilai 'pending' atau 'active'.
// Tujuannya: mencegah typo dan membuat kode lebih terstruktur serta mudah dibaca.
