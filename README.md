lu jual gwe beli

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Git

## langkah2

1. **Clone repository**

    ```bash
    git clone https://github.com/doeta/Tubes-PPL.git
    cd Tubes-PPL
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Copy environment file**

    ```bash
    cp .env.example .env
    ```

4. **Generate application key**

    ```bash
    php artisan key:generate
    ```

5. **Install NPM dependencies**

    ```bash
    npm install
    ```

6. **Build assets**

    ```bash
    npm run build
    ```

7. **Run development server**

    ```bash
    php artisan serve
    ```

8. **Access application**
    - Open browser: http://127.0.0.1:8000


Jika ingin menggunakan hot reload untuk CSS/JS:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```
