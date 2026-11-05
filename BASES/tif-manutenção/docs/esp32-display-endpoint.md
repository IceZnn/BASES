# Receber chamados para exibição no ESP32

O Laravel envia um `POST` JSON para `ESP32_URL + ESP32_DISPLAY_PATH` após um chamado ser criado e confirmado no banco. O caminho padrão é `/chamado/novo`.

Exemplo de corpo:

```json
{
  "id": 42,
  "titulo": "Lâmpada queimada",
  "prioridade": "Nível 2",
  "led": "amarelo",
  "local": "Laboratório (Bloco B, 1º andar)",
  "categoria": "Elétrica",
  "status": "Pendente",
  "criado_em": "2026-10-22T14:30:00+00:00"
}
```

O repositório contém apenas o Laravel, não o firmware Arduino/ESP32. No firmware existente, registre o handler abaixo no mesmo `WebServer` que já atende as rotas dos LEDs. `atualizarDisplay(...)` deve ser ligado à biblioteca e ao modelo de tela instalados no dispositivo.

```cpp
#include <ArduinoJson.h>

void handleNovoChamado() {
  if (!server.hasArg("plain")) {
    server.send(400, "application/json", "{\"ok\":false,\"message\":\"JSON ausente\"}");
    return;
  }

  JsonDocument chamado;
  const DeserializationError erro = deserializeJson(chamado, server.arg("plain"));

  if (erro) {
    server.send(400, "application/json", "{\"ok\":false,\"message\":\"JSON inválido\"}");
    return;
  }

  const String titulo = chamado["titulo"] | "Novo chamado";
  const String prioridade = chamado["prioridade"] | "";
  const String local = chamado["local"] | "";
  const String categoria = chamado["categoria"] | "";

  atualizarDisplay(titulo, prioridade, local, categoria);
  server.send(202, "application/json", "{\"ok\":true}");
}

// Registrar junto às demais rotas, antes de server.begin():
server.on("/chamado/novo", HTTP_POST, handleNovoChamado);
```

O exemplo usa ArduinoJson 7 (`JsonDocument`). Adapte o tipo do documento à versão da biblioteca instalada. A função `atualizarDisplay` é específica do hardware da tela e precisa ser implementada no firmware.
