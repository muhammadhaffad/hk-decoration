<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DecorationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "type" => $this->getTable(),
            "category" => new CategoryResource($this->category),
            "nama" => $this->nama,
            "keterangan" => $this->keterangan,
            "harga" => $this->harga,
            "stok" => $this->stok,
            "jmldisewa" => $this->jmldisewa,
            "gambar" => $this->gambar,
        ];

        $filter = $request->query->get('include');
        
        if($filter == 'ordered') {
            $data['dateOrdered'] = [
                'dariTgl' => $this->orders()->where('tanggalKembali', null)->groupBy('tglSewa', 'tglBongkar')->get()->pluck('tglSewa')->toArray(),
                'sampaiTgl' => $this->orders()->where('tanggalKembali', null)->groupBy('tglSewa', 'tglBongkar')->get()->pluck('tglBongkar')->toArray()
            ];
        }

        return $data;
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
