<?php
    namespace App\Helpers;
 
    class Funcao{
        public static function token_auth() { 
            $user = auth()->user();
            //$user->tokens()->delete();
            if (isset($_COOKIE['token-api-auth'])) {
                $token = $_COOKIE['token-api-auth']; 
            } else {
                $user->tokens()->delete();
                $token = $user->createToken($user['email'])->plainTextToken;
                unset($_COOKIE['token-api-auth']);
                setcookie('token-api-auth', $token); 
            } 
            return $token; 
        } 
        
        public static function verifica_checkbox(string $id_produto, $resultDB) {
            foreach($resultDB as $vendas_itens){
                if($vendas_itens->id_item == $id_produto){
                    return "checked produtoDB=".$vendas_itens->id; 
                } 
            }
        }
        
        public static function dateBR(string $data) {
            $data = explode("-", $data);
            $data = $data[2] . "/" . $data[1] . "/" . $data[0];
            return $data;
        }

        public static function datetimeBR(string $data) {
            $data = explode(" ", $data);
            $data_dia = explode("-", $data[0]); 
            $data_horario = explode(":", $data[1]);
            $data = $data_horario[0] . ":" . $data_horario[1] . " - " . $data_dia[2] . "/" . $data_dia[1] . "/" . $data_dia[0];
            return $data;
        }

        public static function data_nascimentoBR(string $data) {
            $data = explode(" ", $data);
            $data_dia = explode("-", $data[0]); 
            $data_horario = explode(":", $data[1]);
            $data = $data_dia[2] . "/" . $data_dia[1] . "/" . $data_dia[0];
            return $data;
        }

        public static function data_nascimentoUSA(string $data) {
            $data = explode(" ", $data);
            $data_dia = explode("-", $data[0]); 
            $data_horario = explode(":", $data[1]);
            $data = $data_dia[0] . "-" . $data_dia[1] . "-" . $data_dia[2];
            return $data;
        }

        public static function datas_dashboard(string $tipo, string $data) {
            $data = explode(" ", $data);
            $data_dia = explode("-", $data[0]);     
            if($tipo == "BR"){
                $data = $data_dia[1] . "/" . $data_dia[0];
            }else{
                $data = $data_dia[0] . "-" . $data_dia[1];
            }
            return $data;
        }

        public static function datas_remove_dia(string $data) {
            $data = explode(" ", $data);
            $data_dia = explode("-", $data[0]);     
            $data = $data_dia[0] . "-" . $data_dia[1];
            return $data;
        }

        public static function data_atual() {
            date_default_timezone_set('America/Sao_Paulo');
            return date('Y-m-d');
        }
    }