<div wire:poll.5s.visible class="bk" id="top">

    <section class="wrap hero" aria-labelledby="judul">
        <div>
            <h1 id="judul">Informasi Ketersediaan<br>Stok Benih BRMP Aneka Kacang</h1>
            <p class="lead">Data stok setiap varietas diambil langsung dari sistem inventaris. Pilih komoditas, lihat kelas benih, dan cek ketersediaan terkini.</p>
            <div class="cta">
                <a class="btn btn-dark" href="#katalog">Cek stok varietas</a>
                <a class="btn btn-line" href="#kelas">Apa itu BS, FS, SS?</a>
            </div>
        </div>

        <aside class="ledger" aria-label="Ringkasan total stok">
            <div class="ledger-top">
                <span class="lbl">Total stok tercatat</span>
            </div>
            <div class="big">{{ $grandText }}<small>kg</small></div>
            <div class="segs" aria-hidden="true">
                @foreach($segs as $s)
                    <div style="width: {{ $s['pct'] }}; background-color: {{ $s['color'] }}"></div>
                @endforeach
            </div>
            <div class="lrows">
                @foreach($classes as $k)
                    <div class="lrow">
                        <span class="code"><i style="background-color: {{ $k['color'] }}"></i>{{ $k['code'] }}</span>
                        <span class="nm">{{ $k['label'] }}</span>
                        <span class="vv">{{ $k['totalText'] }} kg</span>
                        <span class="pp">{{ $k['pct'] }}</span>
                    </div>
                @endforeach
            </div>
        </aside>
    </section>

    <section class="sec wrap" id="kelas" aria-labelledby="judul-kelas">
        <div class="sec-head">
            <div>
                <h2 id="judul-kelas">Tiga kelas benih, satu rantai mutu</h2>
                <p>BS, FS, dan SS adalah tingkatan benih berdasarkan hierarki perbanyakan untuk menjaga kemurnian dan mutu genetik varietas.</p>
            </div>
        </div>
        <div class="kelas">
            @foreach($classes as $k)
                <div class="kcell">
                    <div class="kbar" style="background-color: {{ $k['color'] }}"></div>
                    <span class="step">Kelas {{ $k['step'] }}</span>
                    <div class="kcode">{{ $k['code'] }}</div>
                    <h3>{{ $k['label'] }}</h3>
                    <p>{{ $k['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="cat" id="katalog" aria-labelledby="judul-katalog">
        <div class="wrap sec">
            <div class="sec-head">
                <div>
                    <h2 id="judul-katalog">Stok per varietas</h2>
                    <p>Menampilkan stok benih yang tersedia saat ini.</p>
                </div>
            </div>

            @if($noResults)
                <div class="vc-empty">
                    <p>Belum ada data stok yang tersedia.</p>
                </div>
            @else
                <div class="vc-grid">
                    @foreach($cards as $card)
                        <article class="vc-card" wire:key="vc-{{ $card['key'] }}" style="--vc-accent: {{ $card['color'] }}">
                            <div class="vc-card__top">
                                <span class="vc-card__cat">{{ $card['category'] }}</span>
                                <span class="vc-card__badge" style="background-color: {{ $card['color'] }}">
                                    {{ $card['class_code'] }}
                                </span>
                            </div>
                            <div class="vc-card__name">{{ $card['variety'] }}</div>
                            <div class="vc-card__class">{{ $card['class_name'] }}</div>
                            <div class="vc-card__stock">
                                {{ $card['stock'] }}<span class="vc-card__unit">kg</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

</div>