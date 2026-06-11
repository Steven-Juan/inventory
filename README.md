# Inventory Steven

Aplikasi inventory berbasis Laravel untuk tiga service:

1. `pencatatan` - master barang dan mutasi stok masuk/keluar.
2. `cetak laporan` - laporan stok, halaman print, dan export CSV.
3. `notif dan komunikasi` - pesan internal dan notifikasi stok minimum.

## Menjalankan Dengan Docker Compose

Pastikan Docker Desktop sudah berjalan, lalu jalankan:

```bash
docker compose up --build
```

Traefik akan membuka route:

- `http://localhost/pencatatan`
- `http://localhost/laporan`
- `http://localhost/komunikasi`
- Dashboard Traefik: `http://localhost:8080`

Database memakai PostgreSQL Neon sesuai connection string pada `docker-compose.yml`.

## Perintah Berguna

```bash
docker compose run --rm notif-komunikasi php artisan migrate --force
docker compose run --rm notif-komunikasi php artisan queue:work --tries=3
```

