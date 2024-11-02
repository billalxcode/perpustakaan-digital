import json
import requests

url = "https://perpustakaan.bappenas.go.id/e-library/data/get-data-buku"

headers = {
    "accept": "application/json, text/javascript, */*; q=0.01",
    "accept-language": "id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
    "content-type": "application/x-www-form-urlencoded; charset=UTF-8",
    "sec-ch-ua": '"Chromium";v="130", "Google Chrome";v="130", "Not?A_Brand";v="99"',
    "sec-ch-ua-mobile": "?0",
    "sec-ch-ua-platform": '"Windows"',
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "Cookie": "elibB4Pp3Na5=59ea673cb6c597ebab2ce3190c79d311; digilib_bappenas=hicbs6cgasla4u7jaalt54s56u6vuckt; _ga=GA1.1.1861326515.1729686348; _ga_7X8CMNLX4R=GS1.1.1729686347.1.1.1729686362.45.0.0",
    "sec-fetch-site": "same-origin",
    "x-requested-with": "XMLHttpRequest",
}

data = {
    "draw": "2",
    "columns[0][data]": "file_image",
    "columns[0][searchable]": "true",
    "columns[0][orderable]": "false",
    "columns[1][data]": "judul",
    "columns[1][searchable]": "true",
    "columns[1][orderable]": "true",
    "columns[2][data]": "pengarang",
    "columns[2][searchable]": "true",
    "columns[2][orderable]": "true",
    "columns[3][data]": "penerbit",
    "columns[3][searchable]": "true",
    "columns[3][orderable]": "true",
    "columns[4][data]": "tahun_terbit",
    "columns[4][searchable]": "true",
    "columns[4][orderable]": "true",
    "columns[5][data]": "kode_panggil_ddc",
    "columns[5][searchable]": "true",
    "columns[5][orderable]": "true",
    "columns[6][data]": "no_rak",
    "columns[6][searchable]": "true",
    "columns[6][orderable]": "true",
    "columns[7][data]": "function",
    "columns[7][searchable]": "true",
    "columns[7][orderable]": "true",
    "columns[8][data]": "file_teks",
    "columns[8][searchable]": "false",
    "columns[8][orderable]": "true",
    "columns[9][data]": "file_teks",
    "columns[9][searchable]": "false",
    "columns[9][orderable]": "true",
    "columns[10][data]": "function",
    "columns[10][searchable]": "true",
    "columns[10][orderable]": "false",
    "start": "10",
    "length": "10",
    "search[value]": "",
    "search[regex]": "false",
    "judulbuku": "",
    "pengarang": "",
    "penerbit": "",
    "tahunterbit": "",
    "elibB4Pp3Na5": "59ea673cb6c597ebab2ce3190c79d311",
}

response = requests.post(url, headers=headers, data=data)
jsn = json.loads(response.text)

