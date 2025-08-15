# Docker Deployment Guide for Render

This guide will help you deploy your Laravel application to Render using Docker.

## Prerequisites

- A Render account
- Your Laravel application code pushed to a Git repository
- Database credentials (MySQL/PostgreSQL)

## Files Created

- `Dockerfile` - Main container configuration
- `docker/nginx.conf` - Nginx web server configuration
- `docker/supervisord.conf` - Process management
- `docker/entrypoint.sh` - Container initialization script
- `.dockerignore` - Build optimization
- `docker-compose.yml` - Local development setup

## Render Deployment Steps

### 1. Connect Your Repository

1. Go to [Render Dashboard](https://dashboard.render.com/)
2. Click "New +" and select "Web Service"
3. Connect your Git repository
4. Select the repository containing your Laravel app

### 2. Configure the Web Service

**Basic Settings:**
- **Name**: Your app name (e.g., `abumart`)
- **Environment**: `Docker`
- **Region**: Choose closest to your users
- **Branch**: `main` (or your default branch)

**Build & Deploy:**
- **Build Command**: Leave empty (Docker will handle this)
- **Start Command**: Leave empty (Dockerfile CMD will handle this)

### 3. Environment Variables

Add these environment variables in Render:

```bash
# Laravel App
APP_NAME="AbuMart"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Redis (if using)
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your_redis_password
REDIS_PORT=6379

# Mail (configure as needed)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email
MAIL_FROM_NAME="${APP_NAME}"

# Queue (if using)
QUEUE_CONNECTION=redis
```

### 4. Database Setup

**Option A: Render PostgreSQL (Recommended)**
1. Create a new PostgreSQL service in Render
2. Use the connection details in your environment variables
3. Update `DB_CONNECTION=postgresql` in environment variables

**Option B: External Database**
- Use your existing MySQL/PostgreSQL database
- Ensure it's accessible from Render's servers

### 5. Deploy

1. Click "Create Web Service"
2. Render will automatically build and deploy your Docker container
3. Monitor the build logs for any issues

## Local Development

To test locally before deploying:

```bash
# Build and run with docker-compose
docker-compose up --build

# Access your app at http://localhost:8000
```

## Troubleshooting

### Common Issues

1. **Build Failures**
   - Check Dockerfile syntax
   - Ensure all required files exist
   - Verify PHP extensions in Dockerfile

2. **Permission Errors**
   - The entrypoint script handles permissions automatically
   - Check if storage and bootstrap/cache directories exist

3. **Database Connection Issues**
   - Verify database credentials
   - Ensure database is accessible from Render
   - Check if migrations are running successfully

### Logs

View logs in Render dashboard or check container logs:

```bash
# Local development
docker-compose logs app

# In Render dashboard
# Go to your service → Logs tab
```

## Performance Optimization

The Dockerfile includes several optimizations:

- Multi-stage build for smaller images
- Gzip compression enabled
- Static asset caching
- Laravel optimization commands
- Security headers
- Rate limiting

## Security Features

- Environment file protection
- Git directory access denied
- Security headers
- Rate limiting on API and login endpoints
- Proper file permissions

## Monitoring

- Supervisor manages all processes
- Automatic restart on failures
- Queue worker included
- Comprehensive logging

## Scaling

Render automatically scales your service based on traffic. The Docker configuration is optimized for:

- Horizontal scaling
- Load balancing
- Stateless operation
- Efficient resource usage

## Support

If you encounter issues:

1. Check Render's [documentation](https://render.com/docs)
2. Review the build logs in Render dashboard
3. Test locally with docker-compose first
4. Ensure all environment variables are set correctly
