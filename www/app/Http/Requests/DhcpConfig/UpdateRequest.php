<?php

namespace App\Http\Requests\DhcpConfig;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'FLAG' => ['nullable', 'boolean'],
            'CAB' => ['nullable', 'numeric', 'gt:0', 'lt:1000'],
            'F' => ['nullable', 'string', 'min:3', 'max:255'],
            'I' => ['nullable', 'string', 'min:3', 'max:255'],
            'O' => ['nullable', 'string', 'min:3', 'max:255'],
            'COMP' => ['required', 'string', 'min:3', 'max:255', 'exists:CAB_IP,COMP'],
            'IP' => ['required', 'string', 'ipv4', 'exists:CAB_IP,IP'],
            'OLD_IP' => ['nullable', 'string', 'ipv4'],
            'MAC' => ['required', 'string', 'mac_address', 'exists:CAB_IP,MAC'],
            'INFO' => ['nullable', 'string', 'min:3'],
        ];
    }

    public function attributes(): array
    {
        return [
            'FLAG' => 'включен/выключен хост',
            'CAB' => 'номер кабинета',
            'F' => 'Фамилия',
            'I' => 'Имя',
            'O' => 'Отчество',
            'COMP' => 'Имя ПЭВМ',
            'IP' => 'IP адрес',
            'OLD_IP' => 'Предыдущий IP адрес',
            'MAC' => 'MAC адрес',
            'INFO' => 'Описание'
        ];
    }
}
