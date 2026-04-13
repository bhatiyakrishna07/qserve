<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QServe — Scan & Order</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * { margin:0; padding:0; box-sizing:border-box; }
            body { font-family:'Nunito',sans-serif; background:#f5f5f5; color:#333; }

            /* ===== HERO ===== */
            .hero {
                background: linear-gradient(135deg, #e8451e 0%, #ff6b3d 50%, #ff8c42 100%);
                color: white;
                padding: 50px 20px 60px;
                text-align: center;
                position: relative;
                overflow: hidden;
            }
            .hero::before {
                content: '';
                position: absolute;
                top: -50%; left: -50%;
                width: 200%; height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
            }
            .hero-logo {
                font-size: 2.8rem;
                font-weight: 900;
                letter-spacing: 2px;
                margin-bottom: 8px;
            }
            .hero-logo span { opacity: 0.85; }
            .hero-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin-bottom: 40px;
                font-weight: 600;
            }

            /* QR Scan Box */
            .scan-box {
                background: white;
                border-radius: 20px;
                padding: 30px 24px;
                max-width: 340px;
                margin: 0 auto;
                box-shadow: 0 8px 40px rgba(0,0,0,0.15);
                position: relative;
                z-index: 1;
            }
            .scan-icon {
                font-size: 4rem;
                margin-bottom: 12px;
                display: block;
            }
            .scan-box h2 {
                font-size: 1.2rem;
                font-weight: 800;
                color: #333;
                margin-bottom: 8px;
            }
            .scan-box p {
                font-size: 0.85rem;
                color: #888;
                margin-bottom: 20px;
                line-height: 1.5;
            }
            .scan-steps {
                display: flex;
                justify-content: space-around;
                margin-bottom: 20px;
            }
            .scan-step {
                text-align: center;
                flex: 1;
            }
            .step-num {
                width: 32px; height: 32px;
                border-radius: 50%;
                background: #e8451e;
                color: white;
                font-weight: 800;
                font-size: 0.85rem;
                display: flex; align-items: center; justify-content: center;
                margin: 0 auto 6px;
            }
            .step-label {
                font-size: 0.72rem;
                color: #666;
                font-weight: 600;
            }
            .step-divider {
                flex: 0.3;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ddd;
                font-size: 1.2rem;
                padding-bottom: 20px;
            }
            .scan-btn {
                display: block;
                width: 100%;
                background: linear-gradient(135deg, #e8451e, #ff6b3d);
                color: white;
                border: none;
                padding: 14px;
                border-radius: 12px;
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: 1rem;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
                transition: transform 0.2s, box-shadow 0.2s;
                box-shadow: 0 4px 15px rgba(232,69,30,0.4);
            }
            .scan-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(232,69,30,0.5);
                color: white;
                text-decoration: none;
            }
            .scan-btn i { margin-right: 8px; }

            /* Wave Divider */
            .wave {
                background: linear-gradient(135deg, #e8451e, #ff8c42);
                line-height: 0;
            }
            .wave svg { display: block; }

            /* ===== MENU SECTION ===== */
            .menu-section { padding: 30px 16px 60px; }

            .section-header {
                text-align: center;
                margin-bottom: 24px;
            }
            .section-header h2 {
                font-size: 1.6rem;
                font-weight: 900;
                color: #333;
            }
            .section-header p {
                color: #888;
                font-size: 0.9rem;
                margin-top: 4px;
            }
            .divider {
                width: 50px; height: 4px;
                background: #e8451e;
                border-radius: 2px;
                margin: 10px auto 0;
            }

            /* Category Tabs */
            .category-tabs {
                display: flex;
                gap: 10px;
                overflow-x: auto;
                padding: 0 4px 12px;
                margin-bottom: 20px;
            }
            .category-tabs::-webkit-scrollbar { display: none; }
            .tab-btn {
                padding: 8px 20px;
                border-radius: 20px;
                border: 2px solid #e8451e;
                background: white;
                color: #e8451e;
                font-family: 'Nunito', sans-serif;
                font-weight: 700;
                font-size: 0.85rem;
                cursor: pointer;
                white-space: nowrap;
                transition: all 0.2s;
            }
            .tab-btn.active {
                background: #e8451e;
                color: white;
            }

            /* Food Items Grid */
            .items-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 14px;
                max-width: 900px;
                margin: 0 auto;
            }
            .item-card {
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0,0,0,0.08);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .item-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.12);
            }
            .item-img {
                width: 100%; height: 130px;
                object-fit: cover;
            }
            .item-img-placeholder {
                width: 100%; height: 130px;
                background: linear-gradient(135deg, #f8f8f8, #f0f0f0);
                display: flex; align-items: center; justify-content: center;
                color: #ddd; font-size: 2.5rem;
            }
            .item-body { padding: 12px; }
            .item-name {
                font-weight: 800;
                font-size: 0.9rem;
                color: #333;
                margin-bottom: 4px;
            }
            .item-desc {
                font-size: 0.75rem;
                color: #999;
                margin-bottom: 8px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                line-height: 1.4;
            }
            .item-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .item-price {
                font-weight: 900;
                color: #e8451e;
                font-size: 1rem;
            }
            .order-tag {
                font-size: 0.7rem;
                background: #fff3f0;
                color: #e8451e;
                padding: 3px 8px;
                border-radius: 10px;
                font-weight: 700;
            }

            /* Category Section */
            .cat-section { margin-bottom: 36px; }
            .cat-title {
                font-size: 1.1rem;
                font-weight: 800;
                color: #333;
                margin-bottom: 14px;
                padding-left: 12px;
                border-left: 4px solid #e8451e;
            }

            /* Sticky scan CTA */
            .sticky-cta {
                position: fixed;
                bottom: 0; left: 0; right: 0;
                background: #2d2d2d;
                color: white;
                padding: 14px 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                z-index: 100;
                box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
            }
            .sticky-cta p {
                font-size: 0.85rem;
                opacity: 0.8;
            }
            .sticky-cta strong { display: block; font-size: 0.95rem; }
            .sticky-scan-btn {
                background: #e8451e;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 20px;
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: 0.85rem;
                cursor: pointer;
                white-space: nowrap;
                text-decoration: none;
            }

            body { padding-bottom: 70px; }

            @media (min-width: 600px) {
                .items-grid {
                    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                }
                .hero { padding: 60px 20px 70px; }
                .hero-logo { font-size: 3.5rem; }
            }
        </style>
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    </head>
    <body>

        {{-- ===== HERO SECTION ===== --}}
        <div class="hero">
            <div class="hero-logo">
                <i class="fas fa-utensils mr-2"></i> QServe 
            </div>
            <div class="hero-subtitle">Scan • Order • Enjoy</div>

            <div class="scan-box">
                <span class="scan-icon">📱</span>
                <h2>Order From Your Table</h2>
                <p>Scan the QR code on your table to browse the menu and place your order instantly!</p>

                <div class="scan-steps">
                    <div class="scan-step">
                        <div class="step-num">1</div>
                        <div class="step-label">Scan QR<br>on Table</div>
                    </div>
                    <div class="step-divider">›</div>
                    <div class="scan-step">
                        <div class="step-num">2</div>
                        <div class="step-label">Pick<br>Items</div>
                    </div>
                    <div class="step-divider">›</div>
                    <div class="scan-step">
                        <div class="step-num">3</div>
                        <div class="step-label">Place<br>Order</div>
                    </div>
                </div>

                <button onclick="openScanner()" class="scan-btn" style="margin-bottom:10px;">
                    <i class="fas fa-qrcode"></i> Scan QR to Order
                </button>
                <a href="#menu" class="scan-btn"
                style="background:white; color:#e8451e; border:2px solid #e8451e;
                        box-shadow:none; margin-top:4px;">
                    <i class="fas fa-utensils"></i> Browse Menu
                </a>
            </div>
        </div>

        {{-- Wave --}}
        <div class="wave">
            <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,0 L0,0 Z" fill="white"/>
            </svg>
        </div>

        {{-- ===== MENU SECTION ===== --}}
        <div class="menu-section" id="menu">

            <div class="section-header">
                <h2>Our Menu</h2>
                <p>Fresh ingredients, amazing flavors</p>
                <div class="divider"></div>
            </div>

            {{-- Category Tabs --}}
            @if($categories->count() > 1)
            <div class="category-tabs">
                <button class="tab-btn active" onclick="filterCategory('all', this)">
                    🍽️ All
                </button>
                @foreach($categories as $category)
                    <button class="tab-btn"
                            onclick="filterCategory('cat-{{ $category->id }}', this)">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            @endif

            {{-- Food Items by Category --}}
            @forelse($categories as $category)
            <div class="cat-section" id="cat-{{ $category->id }}">
                <div class="cat-title">{{ $category->name }}</div>
                <div class="items-grid">
                    @foreach($category->foodItems as $item)
                    <div class="item-card">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}"
                                class="item-img" alt="{{ $item->name }}">
                        @else
                            <div class="item-img-placeholder">
                                <i class="fas fa-utensils"></i>
                            </div>
                        @endif
                        <div class="item-body">
                            <div class="item-name">{{ $item->name }}</div>
                            @if($item->description)
                                <div class="item-desc">{{ $item->description }}</div>
                            @endif
                            <div class="item-footer">
                                <span class="item-price">₹{{ number_format($item->price, 2) }}</span>
                                <span class="order-tag">
                                    <i class="fas fa-qrcode"></i> Scan
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:60px 20px; color:#aaa;">
                <i class="fas fa-utensils" style="font-size:3rem; margin-bottom:12px; display:block;"></i>
                <p style="font-size:1rem;">Menu coming soon!</p>
            </div>
            @endforelse

        </div>

        {{-- Sticky Bottom CTA --}}
        <div class="sticky-cta">
            <div>
                <strong>Ready to order? 🍴</strong>
                <p>Scan the QR code on your table</p>
            </div>
            <button onclick="openScanner()" class="sticky-scan-btn">
                <i class="fas fa-qrcode mr-1"></i> Scan & Order
            </button>
        </div>

        <script>
        function filterCategory(id, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (id === 'all') {
                document.querySelectorAll('.cat-section').forEach(s => s.style.display = 'block');
            } else {
                document.querySelectorAll('.cat-section').forEach(s => {
                    s.style.display = s.id === id ? 'block' : 'none';
                });
            }
        }
        </script>

        {{-- QR Scanner Modal --}}
        <div id="scannerModal" style="display:none; position:fixed; inset:0;
            background:rgba(0,0,0,0.85); z-index:999;
            display:none; align-items:center; justify-content:center;">

            <div style="background:white; border-radius:20px; overflow:hidden;
                        width:90%; max-width:400px; position:relative;">

                {{-- Modal Header --}}
                <div style="background:linear-gradient(135deg,#e8451e,#ff6b3d);
                            color:white; padding:16px 20px;
                            display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="font-weight:800; font-size:1rem;">
                            <i class="fas fa-qrcode mr-2"></i> Scan Table QR Code
                        </div>
                        <div style="font-size:0.78rem; opacity:0.85; margin-top:2px;">
                            Point camera at the QR code on your table
                        </div>
                    </div>
                    <button onclick="closeScanner()"
                            style="background:rgba(255,255,255,0.2); border:none;
                                color:white; width:32px; height:32px; border-radius:50%;
                                font-size:1.1rem; cursor:pointer; display:flex;
                                align-items:center; justify-content:center;">
                        ✕
                    </button>
                </div>

                {{-- Scanner View --}}
                <div style="padding:20px;">
                    <div id="qr-reader"
                        style="width:100%; border-radius:12px; overflow:hidden;"></div>

                    {{-- Status Message --}}
                    <div id="scanStatus"
                        style="text-align:center; margin-top:14px; font-size:0.85rem;
                                color:#888; font-weight:600;">
                        <i class="fas fa-circle-notch fa-spin mr-1"></i>
                        Starting camera...
                    </div>

                    {{-- Manual Entry Fallback --}}
                    <div style="margin-top:16px; padding-top:16px; border-top:1px solid #f0f0f0;">
                        <p style="font-size:0.78rem; color:#aaa; text-align:center; margin-bottom:8px;">
                            Can't scan? Enter table number manually
                        </p>
                        <div style="display:flex; gap:8px;">
                            <input type="number" id="manualTableId"
                                placeholder="Enter table number"
                                min="1"
                                style="flex:1; padding:10px 12px; border:1px solid #ddd;
                                        border-radius:8px; font-family:'Nunito',sans-serif;
                                        font-size:0.9rem;">
                            <button onclick="goToTableManual()"
                                    style="background:#e8451e; color:white; border:none;
                                        padding:10px 16px; border-radius:8px;
                                        font-family:'Nunito',sans-serif;
                                        font-weight:700; cursor:pointer; font-size:0.85rem;">
                                Go
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            let html5QrCode = null;

            function openScanner() {
                document.getElementById('scannerModal').style.display = 'flex';
                startScanner();
            }

            function closeScanner() {
                document.getElementById('scannerModal').style.display = 'none';
                stopScanner();
            }

            function startScanner() {
                document.getElementById('scanStatus').innerHTML =
                    '<i class="fas fa-circle-notch fa-spin mr-1"></i> Starting camera...';

                html5QrCode = new Html5Qrcode("qr-reader");

                const config = {
                    fps: 10,
                    qrbox: { width: 220, height: 220 },
                    aspectRatio: 1.0
                };

                html5QrCode.start(
                    { facingMode: "environment" }, // use back camera
                    config,
                    onScanSuccess,
                    onScanError
                ).then(() => {
                    document.getElementById('scanStatus').innerHTML =
                        '<i class="fas fa-camera mr-1" style="color:#e8451e;"></i> Align QR code in the box';
                }).catch(err => {
                    document.getElementById('scanStatus').innerHTML =
                        '<i class="fas fa-exclamation-circle mr-1" style="color:#e8451e;"></i> Camera not available. Use manual entry below.';
                });
            }

            function stopScanner() {
                if (html5QrCode) {
                    html5QrCode.stop().catch(() => {});
                    html5QrCode = null;
                }
            }

            function onScanSuccess(decodedText) {
                // Stop scanner immediately
                stopScanner();

                document.getElementById('scanStatus').innerHTML =
                    '<i class="fas fa-check-circle mr-1" style="color:green;"></i> QR Code detected! Redirecting...';

                // Check if it's our menu URL
                if (decodedText.includes('/menu?table=')) {
                    setTimeout(() => {
                        window.location.href = decodedText;
                    }, 800);
                } else {
                    document.getElementById('scanStatus').innerHTML =
                        '<i class="fas fa-times-circle mr-1" style="color:#e8451e;"></i> Invalid QR code. Please scan the table QR code.';

                    // Restart scanner after 2 seconds
                    setTimeout(() => {
                        startScanner();
                    }, 2000);
                }
            }

            function onScanError(error) {
                // Silently ignore scan errors (happens continuously while scanning)
            }

            function goToTableManual() {
                const tableId = document.getElementById('manualTableId').value;
                if (!tableId || tableId < 1) {
                    alert('Please enter a valid table number!');
                    return;
                }
                stopScanner();
                window.location.href = '/menu?table=' + tableId;
            }

            // Close modal on backdrop click
            document.getElementById('scannerModal').addEventListener('click', function(e) {
                if (e.target === this) closeScanner();
            });
        </script>

    </body>
</html>