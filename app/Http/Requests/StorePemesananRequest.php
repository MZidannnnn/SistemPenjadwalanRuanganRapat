<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Pemesanan;
use Carbon\Carbon;


class StorePemesananRequest extends FormRequest
{

    protected $errorBag = 'create';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {

        if ($this->tanggal && $this->waktu_mulai) {
            $this->merge([
                'waktu_mulai' => $this->tanggal . ' ' . $this->waktu_mulai,
            ]);
        }
        if ($this->tanggal && $this->waktu_selesai) {
            $this->merge([
                'waktu_selesai' => $this->tanggal . ' ' . $this->waktu_selesai,
            ]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ruangan_id'    => ['required', 'exists:ruangan,id'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'waktu_mulai' => ['required', 'date', 'before:waktu_selesai'],
            'waktu_selesai' => ['required', 'date', 'after:waktu_mulai'],
        ];
    }

    public function messages(): array
    {
        return [
            'ruangan_id.required'    => 'Ruangan wajib dipilih.',
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'waktu_mulai.required'   => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'waktu_selesai.after'    => 'Waktu selesai harus setelah waktu mulai.',
            'waktu_mulai.date'       => 'Format waktu mulai tidak valid.',
            'waktu_mulai.before'     => 'Waktu mulai harus sebelum waktu selesai.',

        ];
    }

    /**
     * Konfigurasi validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $ruanganId = $this->input('ruangan_id');
            $startDateTime = $this->input('waktu_mulai');
            $endDateTime = $this->input('waktu_selesai');

            if ($ruanganId && $startDateTime && $endDateTime) {

                $isConflict = Pemesanan::where('ruangan_id', $ruanganId)
                    ->where('status', '!=', 'dibatalkan')
                    ->where(function ($query) use ($startDateTime, $endDateTime) {
                        $query->where('waktu_mulai', '<', $endDateTime)
                            ->where('waktu_selesai', '>', $startDateTime);
                    })
                    ->exists();

                if ($isConflict) {

                    $validator->errors()->add('ruangan_id', 'Jadwal di ruangan ini sudah terisi pada rentang waktu yang dipilih.');
                }
            }
        });
    }
}
