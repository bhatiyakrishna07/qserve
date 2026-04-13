<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QServe Menu — {{ $table->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f5f5f5; padding-bottom:120px; }

        /* Header */
        .header {
            background: linear-gradient(135deg, #e8451e, #ff6b3d);
            color: white; padding: 16px 20px;
            position: sticky; top:0; z-index:100;
            box-shadow: 0 2px 10px rgba(232,69,30,0.3);
        }
        .header h1 { font-size:1.3rem; font-weight:800; }
        .header p { font-size:0.85rem; opacity:0.9; }

        /* Category Tabs */
        .category-tabs {
            background: white; padding: 12px 16px;
            display: flex; gap:10px; overflow-x:auto;
            position: sticky; top:70px; z-index:99;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .category-tabs::-webkit-scrollbar { display:none; }
        .tab-btn {
            padding: 8px 18px; border-radius:20px; border:none;
            background:#f0f0f0; color:#555; font-family:'Nunito',sans-serif;
            font-weight:600; font-size:0.85rem; cursor:pointer;
            white-space:nowrap; transition:all 0.2s;
        }
        .tab-btn.active { background:#e8451e; color:white; }

        /* Food Items */
        .section { padding: 16px; }
        .section-title {
            font-size:1.1rem; font-weight:800; color:#333;
            margin-bottom:12px; padding-bottom:6px;
            border-bottom:2px solid #e8451e;
        }
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
        }
        .item-card {
            background: white; border-radius:12px;
            overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .item-card:hover { transform:translateY(-2px); }
        .item-img {
            width:100%; height:120px; object-fit:cover;
            background:#f0f0f0;
        }
        .item-img-placeholder {
            width:100%; height:120px; background:#f8f8f8;
            display:flex; align-items:center; justify-content:center;
            color:#ccc; font-size:2rem;
        }
        .item-info { padding:10px; }
        .item-name { font-weight:700; font-size:0.9rem; color:#333; margin-bottom:4px; }
        .item-desc { font-size:0.75rem; color:#888; margin-bottom:8px;
                     display:-webkit-box; -webkit-line-clamp:2;
                     -webkit-box-orient:vertical; overflow:hidden; }
        .item-footer { display:flex; justify-content:space-between; align-items:center; }
        .item-price { font-weight:800; color:#e8451e; font-size:0.95rem; }
        .add-btn {
            width:28px; height:28px; border-radius:50%; border:none;
            background:#e8451e; color:white; font-size:1rem;
            cursor:pointer; display:flex; align-items:center; justify-content:center;
            transition:background 0.2s;
        }
        .add-btn:hover { background:#c73518; }

        /* Cart */
        .cart-bar {
            position:fixed; bottom:0; left:0; right:0;
            background:#2d2d2d; color:white;
            padding:14px 20px; z-index:200;
            display:none; align-items:center; justify-content:space-between;
            box-shadow:0 -4px 20px rgba(0,0,0,0.2);
        }
        .cart-bar.visible { display:flex; }
        .cart-info { display:flex; align-items:center; gap:10px; }
        .cart-count {
            background:#e8451e; color:white;
            width:28px; height:28px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-weight:800; font-size:0.85rem;
        }
        .cart-total { font-weight:700; font-size:1rem; }
        .cart-btn {
            background:#e8451e; color:white; border:none;
            padding:10px 22px; border-radius:20px;
            font-family:'Nunito',sans-serif; font-weight:700;
            font-size:0.9rem; cursor:pointer;
        }

        /* Item qty controls */
        .qty-controls {
            display:none; align-items:center; gap:6px;
        }
        .qty-controls.visible { display:flex; }
        .qty-btn {
            width:24px; height:24px; border-radius:50%; border:none;
            background:#e8451e; color:white; font-size:0.9rem;
            cursor:pointer; display:flex; align-items:center; justify-content:center;
        }
        .qty-num { font-weight:800; font-size:0.9rem; min-width:16px; text-align:center; }
    </style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <h1><i class="fas fa-utensils mr-2"></i> QServe Menu</h1>
    <p><i class="fas fa-chair mr-1"></i> {{ $table->name }} &nbsp;|&nbsp;
       <i class="fas fa-users mr-1"></i> Capacity: {{ $table->capacity }}</p>
</div>

{{-- Category Tabs --}}
<div class="category-tabs">
    @foreach($categories as $index => $category)
        <button class="tab-btn {{ $index === 0 ? 'active' : '' }}"
                onclick="scrollToCategory('cat-{{ $category->id }}', this)">
            {{ $category->name }}
        </button>
    @endforeach
</div>

{{-- Menu Items --}}
@foreach($categories as $category)
<div class="section" id="cat-{{ $category->id }}">
    <div class="section-title">{{ $category->name }}</div>
    <div class="items-grid">
        @foreach($category->foodItems as $item)
        <div class="item-card" id="card-{{ $item->id }}">
            @if($item->image)
                <img src="{{ Storage::url($item->image) }}"
                     class="item-img" alt="{{ $item->name }}">
            @else
                <div class="item-img-placeholder">
                    <i class="fas fa-utensils"></i>
                </div>
            @endif
            <div class="item-info">
                <div class="item-name">{{ $item->name }}</div>
                @if($item->description)
                    <div class="item-desc">{{ $item->description }}</div>
                @endif
                <div class="item-footer">
                    <span class="item-price">₹{{ number_format($item->price, 2) }}</span>

                    {{-- Add Button --}}
                    <button class="add-btn" id="add-{{ $item->id }}"
                            onclick="addToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})">
                        <i class="fas fa-plus"></i>
                    </button>

                    {{-- Qty Controls --}}
                    <div class="qty-controls" id="qty-{{ $item->id }}">
                        <button class="qty-btn"
                                onclick="changeQty({{ $item->id }}, -1)">−</button>
                        <span class="qty-num" id="qtynum-{{ $item->id }}">0</span>
                        <button class="qty-btn"
                                onclick="changeQty({{ $item->id }}, 1)">+</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach

{{-- Cart Bar --}}
<div class="cart-bar" id="cartBar">
    <div class="cart-info">
        <div class="cart-count" id="cartCount">0</div>
        <div>
            <div style="font-size:0.75rem; opacity:0.8;">Your Order</div>
            <div class="cart-total" id="cartTotal">₹0.00</div>
        </div>
    </div>
    <button class="cart-btn" onclick="openCheckout()">
        <i class="fas fa-shopping-bag mr-1"></i> Place Order
    </button>
</div>

{{-- Checkout Modal --}}
<div id="checkoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:300; overflow-y:auto;">
    <div style="background:white; margin:20px auto; max-width:480px; border-radius:16px; overflow:hidden;">

        <div style="background:linear-gradient(135deg,#e8451e,#ff6b3d); color:white; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="font-weight:800;"><i class="fas fa-receipt mr-2"></i> Your Order</h3>
            <button onclick="closeCheckout()"
                    style="background:none; border:none; color:white; font-size:1.3rem; cursor:pointer;">
                &times;
            </button>
        </div>

        <div style="padding:20px;">

            {{-- Order Items Summary --}}
            <div id="checkoutItems"></div>

            <hr style="margin:16px 0;">

            {{-- Customer Name --}}
            <div style="margin-bottom:12px;">
                <label style="font-weight:700; font-size:0.9rem; color:#333;">
                    Your Name <span style="color:#888; font-weight:400;">(optional)</span>
                </label>
                <input type="text" id="customerName"
                       placeholder="Enter your name"
                       style="width:100%; padding:10px 12px; border:1px solid #ddd;
                              border-radius:8px; font-family:'Nunito',sans-serif;
                              font-size:0.9rem; margin-top:6px;">
            </div>

            {{-- Notes --}}
            <div style="margin-bottom:16px;">
                <label style="font-weight:700; font-size:0.9rem; color:#333;">
                    Special Instructions <span style="color:#888; font-weight:400;">(optional)</span>
                </label>
                <textarea id="orderNotes" rows="2"
                          placeholder="e.g. No onions, extra spicy..."
                          style="width:100%; padding:10px 12px; border:1px solid #ddd;
                                 border-radius:8px; font-family:'Nunito',sans-serif;
                                 font-size:0.9rem; margin-top:6px; resize:none;"></textarea>
            </div>

            {{-- Total --}}
            <div style="background:#fff8f6; border:2px solid #e8451e; border-radius:10px;
                        padding:12px 16px; display:flex; justify-content:space-between;
                        align-items:center; margin-bottom:16px;">
                <span style="font-weight:700; color:#333;">Total Amount</span>
                <span style="font-weight:800; color:#e8451e; font-size:1.2rem;"
                      id="modalTotal">₹0.00</span>
            </div>

            {{-- Place Order Button --}}
            <form id="orderForm" action="{{ route('customer.order.store') }}" method="POST">
                @csrf
                <input type="hidden" name="table_id" value="{{ $table->id }}">
                <input type="hidden" name="customer_name" id="formCustomerName">
                <input type="hidden" name="notes" id="formNotes">
                <div id="formItems"></div>
                <button type="submit"
                        style="width:100%; background:linear-gradient(135deg,#e8451e,#ff6b3d);
                               color:white; border:none; padding:14px;
                               border-radius:10px; font-family:'Nunito',sans-serif;
                               font-weight:800; font-size:1rem; cursor:pointer;">
                    <i class="fas fa-check-circle mr-2"></i> Confirm Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let cart = {};

    function addToCart(id, name, price) {
        cart[id] = { id, name, price, qty: 1 };
        document.getElementById('add-' + id).style.display = 'none';
        document.getElementById('qty-' + id).classList.add('visible');
        document.getElementById('qtynum-' + id).textContent = 1;
        updateCartBar();
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        cart[id].qty += delta;
        if (cart[id].qty <= 0) {
            delete cart[id];
            document.getElementById('add-' + id).style.display = 'flex';
            document.getElementById('qty-' + id).classList.remove('visible');
            document.getElementById('qtynum-' + id).textContent = 0;
        } else {
            document.getElementById('qtynum-' + id).textContent = cart[id].qty;
        }
        updateCartBar();
    }

    function updateCartBar() {
        const items  = Object.values(cart);
        const count  = items.reduce((s, i) => s + i.qty, 0);
        const total  = items.reduce((s, i) => s + (i.price * i.qty), 0);
        document.getElementById('cartCount').textContent = count;
        document.getElementById('cartTotal').textContent = '₹' + total.toFixed(2);
        document.getElementById('cartBar').classList.toggle('visible', count > 0);
    }

    function openCheckout() {
        const items = Object.values(cart);
        let html = '';
        let total = 0;
        items.forEach(i => {
            const sub = i.price * i.qty;
            total += sub;
            html += `<div style="display:flex;justify-content:space-between;
                                  align-items:center;padding:8px 0;
                                  border-bottom:1px solid #f0f0f0;">
                        <div>
                            <div style="font-weight:700;font-size:0.9rem;">${i.name}</div>
                            <div style="font-size:0.8rem;color:#888;">
                                ₹${i.price.toFixed(2)} × ${i.qty}
                            </div>
                        </div>
                        <div style="font-weight:800;color:#e8451e;">
                            ₹${sub.toFixed(2)}
                        </div>
                    </div>`;
        });
        document.getElementById('checkoutItems').innerHTML = html;
        document.getElementById('modalTotal').textContent = '₹' + total.toFixed(2);
        document.getElementById('checkoutModal').style.display = 'block';
    }

    function closeCheckout() {
        document.getElementById('checkoutModal').style.display = 'none';
    }

    // Build hidden form fields before submit
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        const items = Object.values(cart);
        if (items.length === 0) {
            e.preventDefault();
            alert('Please add items to your order!');
            return;
        }

        document.getElementById('formCustomerName').value =
            document.getElementById('customerName').value;
        document.getElementById('formNotes').value =
            document.getElementById('orderNotes').value;

        // Build items hidden inputs
        let html = '';
        items.forEach((item, index) => {
            html += `<input type="hidden" name="items[${index}][id]" value="${item.id}">`;
            html += `<input type="hidden" name="items[${index}][qty]" value="${item.qty}">`;
        });
        document.getElementById('formItems').innerHTML = html;
    });

    function scrollToCategory(id, btn) {
        document.getElementById(id).scrollIntoView({ behavior:'smooth' });
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }
</script>

</body>
</html>