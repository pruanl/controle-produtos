
# Run npm install if node_modules directory doesn't exist
if [ ! -d "node_modules" ]; then
  yarn install
fi

yarn run dev