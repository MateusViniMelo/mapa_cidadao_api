#!/bin/sh

HOOK_FILE=".git/hooks/pre-commit"

cat << 'EOF' > $HOOK_FILE
#!/bin/sh
echo "Executando Laravel Pint antes do commit..."

docker compose exec -T app ./vendor/bin/pint

if ! git diff --quiet; then
    echo "⚠️ Arquivos foram modificados pelo Pint. Por favor, revise e faça commit novamente."
    exit 1
fi

echo "✅ Laravel Pint finalizado com sucesso!"
EOF

chmod +x $HOOK_FILE
