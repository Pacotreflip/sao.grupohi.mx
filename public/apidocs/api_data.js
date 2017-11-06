define({ "api": [
  {
    "type": "post",
    "url": "/empresa",
    "title": "Registrar Empresa",
    "version": "1.0.0",
    "group": "Empresa",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "rfc",
            "description": "<p>RFC de la Empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "razon_social",
            "description": "<p>Razón Social de la Empresa</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar una Empresa</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error descropton\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos de la Empresa Registrada</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_empresa\": \"xxx\",\n    \"tipo_empresa\": \"x\",\n    \"razon_social\": \"Razón Social\",\n    \"rfc\": \"000000XXX\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/EmpresaController.php",
    "groupTitle": "Empresa",
    "name": "PostEmpresa"
  }
] });
