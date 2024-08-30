<?php

namespace App;

class ApiMessage
{
    public const SOMETHING_WENT_WRONG = 'SOMETHING_WENT_WRONG';
    public const UNAUTHORIZED         = 'UNAUTHORIZED';
    public const VALIDATION_ERROR     = 'VALIDATION_ERROR';
    public const NOT_FOUND            = 'NOT_FOUND';
    public const FAILED_DEPENDENCY    = 'FAILED_DEPENDENCY';
    public const BAD_REQUEST          = 'BAD_REQUEST';
    public const SUCCESFULL_UPDATE    = 'Data berhasil diperbarui dengan sukses';
    public const SUCCESFULL_DELETE    = 'Data telah berhasil dihapus dengan sukses.';
    public const CAN_T_DELETE         = 'Maaf, saat ini data Anda tidak dapat dihapus karena sedang dalam proses';
    public const CAN_T_UPDATE         = 'Maaf, kami tidak dapat mengubah data tersebut karena status data terkait sedang dalam proses verifikasi, penolakan, atau telah diselesaikan.';
    public const CAN_T_FIND_NO_TRACKING = 'Maaf no permohonan tidak di temukan';
    public const NEED_VERIFY           = 'Sebelum melanjutkan, harap lakukan verifikasi terlebih dahulu. Silakan periksa pesan WhatsApp atau email Anda, mungkin berada di folder spam';
    public const ACCOUNT_VERIFIED      = 'Akun Anda telah diverifikasi';
    public const WRONG_VERIFICATION_CODE = 'Mohon maaf, kode verifikasi yang Anda masukkan tidak valid atau telah kadaluarsa.';
    public const SORRY_USER_VERIFIED   = 'Pengguna telah diverifikasi.';
    public const OTP_SENT              = 'Kode OTP berhasil terkirim';
    public const OTP_FAILED_SENT       = 'Kode OTP gagal terkirim';
    public const WRONG_DATA            = "Maaf, kami tidak dapat menemukan data yang Anda cari.";
}
