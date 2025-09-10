FROM node:18

# Establecer directorio de trabajo
WORKDIR /app

# Copiar package.json y package-lock.json
COPY package*.json ./

# Instalar dependencias del proyecto y nodemon globalmente
RUN npm install && npm install -g nodemon

# Copiar el resto del proyecto
COPY . .

# Exponer el puerto
EXPOSE 3000

# Comando para correr la app
CMD ["npm", "run", "dev"]