# frontend/Dockerfile

FROM node:20

# Set working directory
WORKDIR /app

# Install dependencies
COPY package.json yarn.lock ./
RUN yarn install

# Copy application files
COPY . .

# Expose port and start the application
EXPOSE 5173
CMD ["yarn", "dev", "--host"]
