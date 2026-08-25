# ملفات التصميم والإعدادات - Excellence Learning System

## 📱 ملف CSS الرئيسي

```css
/* ==========================================
   Global Styles & Variables
   ========================================== */
:root {
    --primary-color: #2563eb;
    --secondary-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --dark-color: #1f2937;
    --light-color: #f3f4f6;
    --border-radius: 0.5rem;
    --transition: all 0.3s ease;
    --box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    --box-shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
}

/* Arabic Font Support */
@font-face {
    font-family: 'Cairo';
    src: url('/fonts/Cairo-Regular.ttf') format('truetype');
    font-weight: 400;
}

@font-face {
    font-family: 'Cairo';
    src: url('/fonts/Cairo-Bold.ttf') format('truetype');
    font-weight: 700;
}

/* Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: var(--dark-color);
    background-color: #fafafa;
}

/* RTL Support */
[dir="rtl"] {
    text-align: right;
}

[dir="rtl"] .flex {
    direction: rtl;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ==========================================
   Components
   ========================================== */

/* Buttons */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    white-space: nowrap;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: var(--box-shadow-lg);
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
}

.btn-outline {
    background-color: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Form Elements */
.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    font-family: inherit;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* Cards */
.card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    transition: var(--transition);
}

.card:hover {
    box-shadow: var(--box-shadow-lg);
    transform: translateY(-4px);
}

.card-header {
    padding: 1.5rem;
    background-color: var(--light-color);
    border-bottom: 1px solid #e5e7eb;
}

.card-body {
    padding: 1.5rem;
}

.card-footer {
    padding: 1rem 1.5rem;
    background-color: var(--light-color);
    border-top: 1px solid #e5e7eb;
}

/* ==========================================
   Layout Components
   ========================================== */

/* Header */
header {
    background: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.nav-link {
    padding: 0.5rem 1rem;
    color: var(--dark-color);
    text-decoration: none;
    transition: var(--transition);
    border-radius: var(--border-radius);
}

.nav-link:hover {
    background-color: var(--light-color);
    color: var(--primary-color);
}

/* Hero Section */
.hero {
    background: linear-gradient(135deg, var(--primary-color), #3b82f6);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero p {
    font-size: 1.25rem;
    margin-bottom: 2rem;
}

/* Grid System */
.grid {
    display: grid;
    gap: 1.5rem;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, 1fr);
}

@media (min-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .lg\:grid-cols-4 {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* ==========================================
   Page Specific Styles
   ========================================== */

/* Programs Page */
.program-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    transition: var(--transition);
    box-shadow: var(--box-shadow);
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--box-shadow-lg);
}

.program-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background-color: var(--primary-color);
    color: white;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

/* Schedule Table */
.schedule-table {
    width: 100%;
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--box-shadow);
}

.schedule-table thead {
    background-color: var(--primary-color);
    color: white;
}

.schedule-table th,
.schedule-table td {
    padding: 1rem;
    text-align: right;
}

[dir="ltr"] .schedule-table th,
[dir="ltr"] .schedule-table td {
    text-align: left;
}

.schedule-table tbody tr {
    border-bottom: 1px solid #e5e7eb;
}

.schedule-table tbody tr:hover {
    background-color: var(--light-color);
}

/* Registration Steps */
.registration-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
}

.step {
    flex: 1;
    text-align: center;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    background-color: var(--light-color);
    color: var(--dark-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    font-weight: bold;
}

.step.active .step-number {
    background-color: var(--primary-color);
    color: white;
}

.step-line {
    position: absolute;
    top: 20px;
    left: 50%;
    width: 100%;
    height: 2px;
    background-color: var(--light-color);
    z-index: -1;
}

.step.completed .step-line {
    background-color: var(--secondary-color);
}

/* ==========================================
   Utilities
   ========================================== */

/* Spacing */
.mt-1 { margin-top: 0.25rem; }
.mt-2 { margin-top: 0.5rem; }
.mt-4 { margin-top: 1rem; }
.mt-6 { margin-top: 1.5rem; }
.mt-8 { margin-top: 2rem; }

.mb-1 { margin-bottom: 0.25rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-6 { margin-bottom: 1.5rem; }
.mb-8 { margin-bottom: 2rem; }

.p-2 { padding: 0.5rem; }
.p-4 { padding: 1rem; }
.p-6 { padding: 1.5rem; }
.p-8 { padding: 2rem; }

/* Text */
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-left { text-align: left; }

.text-sm { font-size: 0.875rem; }
.text-lg { font-size: 1.125rem; }
.text-xl { font-size: 1.25rem; }
.text-2xl { font-size: 1.5rem; }
.text-3xl { font-size: 1.875rem; }

.font-bold { font-weight: 700; }
.font-semibold { font-weight: 600; }

/* Colors */
.text-primary { color: var(--primary-color); }
.text-secondary { color: var(--secondary-color); }
.text-danger { color: var(--danger-color); }
.text-gray { color: #6b7280; }

.bg-primary { background-color: var(--primary-color); }
.bg-secondary { background-color: var(--secondary-color); }
.bg-light { background-color: var(--light-color); }

/* Flex */
.flex { display: flex; }
.items-center { align-items: center; }
.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }
.gap-2 { gap: 0.5rem; }
.gap-4 { gap: 1rem; }
.gap-6 { gap: 1.5rem; }

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Loading Spinner */
.loading-spinner {
    border: 3px solid var(--light-color);
    border-top: 3px solid var(--primary-color);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 0 0.5rem;
    }
    
    .hero h1 {
        font-size: 2rem;
    }
    
    .hide-mobile {
        display: none;
    }
}

@media print {
    header, footer {
        display: none;
    }
    
    .btn, .no-print {
        display: none;
    }
}
```

## 🐳 Docker Configuration

### Dockerfile للـ Backend

```dockerfile
# Backend Dockerfile
FROM node:16-alpine

WORKDIR /app

# Install dependencies
COPY package*.json ./
RUN npm ci --only=production

# Copy application code
COPY . .

# Create uploads directory
RUN mkdir -p uploads

# Expose port
EXPOSE 3000

# Start the application
CMD ["node", "server.js"]
```

### Dockerfile للـ Frontend

```dockerfile
# Frontend Dockerfile
FROM node:16-alpine AS builder

WORKDIR /app

# Install dependencies
COPY package*.json ./
RUN npm ci

# Copy application code
COPY . .

# Build the application
RUN npm run build

# Production stage
FROM nginx:alpine

# Copy built files
COPY --from=builder /app/build /usr/share/nginx/html

# Copy nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
```

### docker-compose.yml

```yaml
version: '3.8'

services:
  # MySQL Database
  database:
    image: mysql:8.0
    container_name: excellence_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./database/init.sql:/docker-entrypoint-initdb.d/init.sql
    networks:
      - excellence_network

  # Redis Cache
  redis:
    image: redis:alpine
    container_name: excellence_redis
    restart: always
    ports:
      - "6379:6379"
    networks:
      - excellence_network

  # Backend API
  backend:
    build:
      context: ./backend
      dockerfile: Dockerfile
    container_name: excellence_backend
    restart: always
    ports:
      - "3000:3000"
    environment:
      NODE_ENV: production
      DB_HOST: database
      DB_USER: ${DB_USER}
      DB_PASSWORD: ${DB_PASSWORD}
      DB_NAME: ${DB_NAME}
      REDIS_HOST: redis
      JWT_SECRET: ${JWT_SECRET}
      SMTP_HOST: ${SMTP_HOST}
      SMTP_USER: ${SMTP_USER}
      SMTP_PASS: ${SMTP_PASS}
    depends_on:
      - database
      - redis
    volumes:
      - ./backend:/app
      - /app/node_modules
      - uploads:/app/uploads
    networks:
      - excellence_network

  # Frontend React App
  frontend:
    build:
      context: ./frontend
      dockerfile: Dockerfile
    container_name: excellence_frontend
    restart: always
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./frontend/nginx.conf:/etc/nginx/conf.d/default.conf
      - ./ssl:/etc/nginx/ssl
    depends_on:
      - backend
    networks:
      - excellence_network

  # PhpMyAdmin
  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: excellence_phpmyadmin
    restart: always
    ports:
      - "8080:80"
    environment:
      PMA_HOST: database
      PMA_USER: root
      PMA_PASSWORD: ${DB_ROOT_PASSWORD}
      UPLOAD_LIMIT: 50M
    depends_on:
      - database
    networks:
      - excellence_network

  # Backup Service
  backup:
    image: mysql:8.0
    container_name: excellence_backup
    volumes:
      - ./backups:/backups
      - ./scripts/backup.sh:/backup.sh
    entrypoint: ["/bin/sh", "/backup.sh"]
    environment:
      MYSQL_HOST: database
      MYSQL_USER: root
      MYSQL_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
    depends_on:
      - database
    networks:
      - excellence_network

networks:
  excellence_network:
    driver: bridge

volumes:
  db_data:
  uploads:
```

## ⚙️ Nginx Configuration

```nginx
# nginx.conf
server {
    listen 80;
    server_name excellencelrn.com www.excellencelrn.com;
    
    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name excellencelrn.com www.excellencelrn.com;
    
    # SSL Configuration
    ssl_certificate /etc/nginx/ssl/cert.pem;
    ssl_certificate_key /etc/nginx/ssl/key.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    
    # Root directory
    root /usr/share/nginx/html;
    index index.html;
    
    # Gzip compression
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
    
    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
    
    # API Proxy
    location /api {
        proxy_pass http://backend:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # React App
    location / {
        try_files $uri $uri/ /index.html;
    }
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
}
```

## 🔐 Environment Variables (.env)

```bash
# Application
APP_NAME="Excellence Learning"
APP_ENV=production
APP_URL=https://excellencelrn.com
APP_PORT=3000

# Database
DB_HOST=localhost
DB_PORT=3306
DB_NAME=excellence_training
DB_USER=excellence_user
DB_PASSWORD=secure_password_here
DB_ROOT_PASSWORD=root_password_here

# Redis
REDIS_HOST=localhost
REDIS_PORT=6379

# JWT
JWT_SECRET=your_super_secret_jwt_key_here
JWT_EXPIRES_IN=7d
JWT_REFRESH_SECRET=your_refresh_token_secret_here
JWT_REFRESH_EXPIRES_IN=30d

# Email (SMTP)
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_SECURE=false
SMTP_USER=your_email@gmail.com
SMTP_PASS=your_app_specific_password
ADMIN_EMAIL=admin@excellencelrn.com

# Payment Gateway
PAYMENT_GATEWAY=stripe
STRIPE_PUBLIC_KEY=pk_test_xxx
STRIPE_SECRET_KEY=sk_test_xxx
PAYMENT_CURRENCY=SAR

# File Upload
UPLOAD_MAX_SIZE=10485760
UPLOAD_ALLOWED_TYPES=jpg,jpeg,png,pdf,doc,docx
UPLOAD_PATH=./uploads

# Session
SESSION_SECRET=your_session_secret_here
SESSION_MAX_AGE=86400000

# API Keys
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
GOOGLE_ANALYTICS_ID=UA-XXXXXXXXX-X
RECAPTCHA_SITE_KEY=your_recaptcha_site_key
RECAPTCHA_SECRET_KEY=your_recaptcha_secret_key

# SMS Gateway (Twilio)
TWILIO_ACCOUNT_SID=your_twilio_account_sid
TWILIO_AUTH_TOKEN=your_twilio_auth_token
TWILIO_PHONE_NUMBER=+1234567890

# Social Media
FACEBOOK_APP_ID=your_facebook_app_id
TWITTER_API_KEY=your_twitter_api_key
LINKEDIN_CLIENT_ID=your_linkedin_client_id

# Backup
BACKUP_ENABLED=true
BACKUP_SCHEDULE="0 2 * * *"
BACKUP_RETENTION_DAYS=30
BACKUP_S3_BUCKET=excellence-backups

# Monitoring
SENTRY_DSN=https://xxx@sentry.io/xxx
LOG_LEVEL=info
LOG_FILE=./logs/app.log

# Security
RATE_LIMIT_WINDOW_MS=900000
RATE_LIMIT_MAX_REQUESTS=100
CORS_ORIGIN=https://excellencelrn.com
HELMET_ENABLED=true

# Feature Flags
FEATURE_ONLINE_PAYMENT=true
FEATURE_SMS_NOTIFICATIONS=true
FEATURE_EMAIL_VERIFICATION=true
FEATURE_TWO_FACTOR_AUTH=false
```

## 📝 Package.json للـ Backend

```json
{
  "name": "excellence-learning-backend",
  "version": "1.0.0",
  "description": "Excellence Learning Training System Backend",
  "main": "server.js",
  "scripts": {
    "start": "node server.js",
    "dev": "nodemon server.js",
    "test": "jest",
    "migrate": "node migrations/run.js",
    "seed": "node seeders/run.js",
    "backup": "node scripts/backup.js"
  },
  "dependencies": {
    "express": "^4.18.2",
    "mysql2": "^3.6.0",
    "bcryptjs": "^2.4.3",
    "jsonwebtoken": "^9.0.2",
    "cors": "^2.8.5",
    "dotenv": "^16.3.1",
    "express-validator": "^7.0.1",
    "helmet": "^7.0.0",
    "express-rate-limit": "^6.10.0",
    "multer": "^1.4.5-lts.1",
    "nodemailer": "^6.9.4",
    "redis": "^4.6.7",
    "morgan": "^1.10.0",
    "compression": "^1.7.4",
    "express-session": "^1.17.3",
    "passport": "^0.6.0",
    "passport-jwt": "^4.0.1",
    "stripe": "^13.3.0",
    "twilio": "^4.15.0",
    "winston": "^3.10.0",
    "joi": "^17.9.2",
    "moment": "^2.29.4",
    "axios": "^1.4.0"
  },
  "devDependencies": {
    "nodemon": "^3.0.1",
    "jest": "^29.6.2",
    "supertest": "^6.3.3",
    "eslint": "^8.46.0",
    "prettier": "^3.0.1"
  }
}
```

## 📝 Package.json للـ Frontend

```json
{
  "name": "excellence-learning-frontend",
  "version": "1.0.0",
  "private": true,
  "dependencies": {
    "react": "^18.2.0",
    "react-dom": "^18.2.0",
    "react-router-dom": "^6.14.2",
    "axios": "^1.4.0",
    "react-hook-form": "^7.45.2",
    "react-query": "^3.39.3",
    "i18next": "^23.4.4",
    "react-i18next": "^13.0.3",
    "tailwindcss": "^3.3.3",
    "react-hot-toast": "^2.4.1",
    "react-datepicker": "^4.16.0",
    "react-select": "^5.7.4",
    "recharts": "^2.7.2",
    "react-table": "^7.8.0",
    "framer-motion": "^10.15.0",
    "react-icons": "^4.10.1",
    "date-fns": "^2.30.0",
    "yup": "^1.2.0"
  },
  "scripts": {
    "start": "react-scripts start",
    "build": "react-scripts build",
    "test": "react-scripts test",
    "eject": "react-scripts eject"
  },
  "devDependencies": {
    "react-scripts": "5.0.1",
    "@types/react": "^18.2.18",
    "@types/react-dom": "^18.2.7",
    "typescript": "^5.1.6",
    "eslint": "^8.46.0",
    "prettier": "^3.0.1"
  },
  "browserslist": {
    "production": [
      ">0.2%",
      "not dead",
      "not op_mini all"
    ],
    "development": [
      "last 1 chrome version",
      "last 1 firefox version",
      "last 1 safari version"
    ]
  }
}
```

## 🚀 نصوص التشغيل

### start.sh
```bash
#!/bin/bash

# Start script for Excellence Learning System

echo "🚀 Starting Excellence Learning System..."

# Check environment
if [ ! -f .env ]; then
    echo "❌ .env file not found!"
    exit 1
fi

# Start services
docker-compose up -d

# Wait for database to be ready
echo "⏳ Waiting for database..."
sleep 10

# Run migrations
docker exec excellence_backend npm run migrate

# Seed initial data
docker exec excellence_backend npm run seed

echo "✅ System is running!"
echo "🌐 Frontend: http://localhost"
echo "🔧 Backend: http://localhost:3000"
echo "📊 PhpMyAdmin: http://localhost:8080"
```

### backup.sh
```bash
#!/bin/bash

# Backup script
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups"
DB_NAME="excellence_training"

# Create backup
mysqldump -h $MYSQL_HOST -u $MYSQL_USER -p$MYSQL_PASSWORD $DB_NAME > $BACKUP_DIR/backup_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/backup_$DATE.sql

# Remove old backups (older than 30 days)
find $BACKUP_DIR -name "backup_*.sql.gz" -mtime +30 -delete

echo "✅ Backup completed: backup_$DATE.sql.gz"
```
