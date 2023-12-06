<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    protected $with = ['level_admin'];

    public function level_admin(): BelongsTo
    {
        return $this->belongsTo(LevelAdmin::class, 'level_admin_id');
    }
    
    public function seksi(): BelongsTo
    {
        return $this->belongsTo(Seksi::class, 'seksi_id');
    }
    
    public function seksi_authors(): HasMany
    {
        return $this->hasMany(Seksi::class, 'author_id');
    }

    public function bidang(): HasMany
    {
        return $this->hasMany(Bidang::class, 'author_id');
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'author_id');
    }

    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'author_id');
    }

    public function tanda_tangans(): HasMany
    {
        return $this->hasMany(TandaTangan::class, 'author_id');
    }

    public function alat_angkuts(): HasMany
    {
        return $this->hasMany(AlatAngkut::class, 'author_id');
    }

    public function jabatans(): HasMany
    {
        return $this->hasMany(Jabatan::class, 'author_id');
    }

    public function ketentuans(): HasMany
    {
        return $this->hasMany(Ketentuan::class, 'author_id');
    }

    public function golongans(): HasMany
    {
        return $this->hasMany(Golongan::class, 'author_id');
    }

    public function jenis_perdins(): HasMany
    {
        return $this->hasMany(JenisPerdin::class, 'author_id');
    }

    public function provinsis(): HasMany
    {
        return $this->hasMany(Provinsi::class, 'author_id');
    }

    public function kota_kabupatens(): HasMany
    {
        return $this->hasMany(KotaKabupaten::class, 'author_id');
    }

    public function uang_harians(): HasMany
    {
        return $this->hasMany(UangHarian::class, 'author_id');
    }

    public function uang_transports(): HasMany
    {
        return $this->hasMany(UangTransport::class, 'author_id');
    }

    public function biaya_perdins(): HasMany
    {
        return $this->hasMany(BiayaPerdin::class, 'author_id');
    }

    public function laporan_perdin(): HasMany
    {
        return $this->hasMany(LaporanPerdin::class, 'laporan_perdin_id');
    }

    public function kwitansi_perdin(): HasMany
    {
        return $this->hasMany(KwitansiPerdin::class, 'kwitansi_perdin_id');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
