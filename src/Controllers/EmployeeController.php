<?php

namespace App\Controllers;

use SimpleXMLElement;

class EmployeeController extends BaseController
{

    public function index($request, $response, $args)
    {
        $email = isset($request->getQueryParams()['email'])? trim($request->getQueryParams()['email']) : null;

        $params = [
            'search'    => 'email',
            'email'     => $email
        ];

        $view['employee']   = $this->dataEmployee($params);
        $view['email']      = $email;

        return $this->view->render($response, 'employee.phtml', $view);
    }

    public function show($request, $response, $args)
    {
        $id = isset($args['id'])? trim($args['id']) : null;

        $params = [
            'search'    => 'id',
            'id'        => $id
        ];

        $view['data']       = null;

        if(!empty($id)){
            $data['employee']   = $this->dataEmployee($params);

            foreach ($data['employee'] as $key => $row) {
                if($args['id'] == $row['id']){
                    $view['data'] = $row;

                    break;
                }
            }
        }
        $view['skills'] = [
            'Python',
            'CSS',
            'C#',
            'JS',
            'Lisp',
            'NoSQL',
            'Java',
            'Ruby',
            'HTML',
            'PHP',
            'SQL'
        ];

        $view['behavior'] = empty($id)? 'new' : 'detail';

        return $this->view->render($response, 'detail.phtml', $view);
    }

    public function store($request, $response, $args)
    {
        return $response->withRedirect('/employee');

        $getRequest = $request->getParsedBody();

        $salary = '$' . number_format(trim($getRequest['salary']), 2, '.', ',');

        $data = [
            'id'        => $this->code(25),
            'salary'    => $salary,
            'position'  => trim($getRequest['position']),
            'name'      => trim($getRequest['name']),
            'email'     => trim($getRequest['email']),
            'phone'     => trim($getRequest['phone']),
            'address'   => trim($getRequest['address']),
            'skills'    => $this->formatSkill($getRequest['skills'])
        ];

        $employees  = file_get_contents($this->basePath . "data/employees.json");
        $gEmployees = json_decode($employees, true);
        $count      = count($gEmployees);

        $gEmployees[] = $data;

        $fh = fopen($this->basePath . "data/employees.json", 'w');

        fwrite($fh, json_encode($gEmployees,JSON_UNESCAPED_UNICODE));
        fclose($fh);

        return $response->withRedirect('/employee');
    }

    /**
     * Formato de array de skill, para poder guardar en base al formato establecido por el file (JSON)
     *
     * @param (array) $skill ---> todos los datos del skill
     * @return array|null
     */
    private function formatSkill($skill)
    {
        $data = null;

        foreach ($skill as $key => $value){
            $data[] = ['skill' => $value];
        }

        return $data;
    }

    /**
     * Generamos un codigo alfanumerico
     *
     * @param int $length ----> numero de caracteres que tendra el codigo
     * @return bool|string
     */
    private function code($length = 24)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
    }

    /**
     *  Soportado para busqueda de email y id de usuario
     *
     * @param (array) $params ---> valores
     * @return Json
     */
    private function dataEmployee($params)
    {
        $employees  = file_get_contents($this->basePath . "data/employees.json");
        $gEmployees = json_decode($employees, true);
        $data       = $gEmployees;

        foreach ($gEmployees as $key => $row) {
            if($params[$params['search']] == $row[$params['search']]){
                $data = [];
                $data[] = $row;

                break;
            }
        }

        return $data;
    }

    /**
     * (WS - XML)
     *  Devuelve en XML
     */
    public function getApp($request, $response)
    {
        try {
            $min = isset($request->getQueryParams()['min'])? trim($request->getQueryParams()['min']) : null;
            $max = isset($request->getQueryParams()['max'])? trim($request->getQueryParams()['max']) : null;

            $min = number_format($min, 2, '.', ',');
            $max = number_format($max, 2, '.', ',');

            $min = $this->filterNumber($min);
            $max = $this->filterNumber($max);

            $employees  = file_get_contents($this->basePath . "data/employees.json");
            $gEmployees = json_decode($employees, true);

            $data = null;

            $xml = new SimpleXMLElement('<root/>');

            foreach ($gEmployees as $key => $row) {
                $salary = $this->filterNumber(substr($row['salary'], 1));

                if($salary >= $min && $salary <= $max){
                    $item = $xml->addChild('item');

                    $item->addChild('id', $row['id']);
                    $item->addChild('name', $row['email']);
                    $item->addChild('phone', $row['phone']);
                    $item->addChild('address', $row['address']);
                    $item->addChild('position', $row['position']);
                    $item->addChild('salary', $row['salary']);
                }
            }

            $newXml = $xml->asXml();

            $response->getBody()->write($newXml);

            return $response->withHeader('Content-type', 'application/xml; charset=utf-8');

        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }

    }

    /**
     * Filtra las (,) y (.)
     *
     * @param $value
     * @return int
     */
    private function filterNumber($value)
    {
        $value = trim($value);
        $value = str_replace('.','',$value);
        $value = str_replace(',','',$value);

        return (int)$value;
    }
}