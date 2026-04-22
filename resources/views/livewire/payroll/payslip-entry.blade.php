<div class="pe-root">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

        /* ══ TOKENS ══════════════════════════════════════════════ */
        .pe-root {
            --blue: #3B6FE8;
            --blue-2: #2755CC;
            --blue-3: #1A3FA8;
            --blue-lt: rgba(59, 111, 232, 0.09);
            --blue-mid: rgba(59, 111, 232, 0.18);
            --blue-brd: rgba(59, 111, 232, 0.22);
            --green: #12B76A;
            --green-lt: rgba(18, 183, 106, 0.10);
            --amber: #F59E0B;
            --amber-lt: rgba(245, 158, 11, 0.10);
            --red: #EF4444;
            --red-lt: rgba(239, 68, 68, 0.09);
            --purple: #7C3AED;
            --purple-lt: rgba(124, 58, 237, 0.09);
            --indigo: #6B4FDB;
            --bg: #F0F4FA;
            --white: #FFFFFF;
            --ink: #0F1629;
            --ink2: #2D3356;
            --ink3: #6B7094;
            --ink4: #A8ADCA;
            --border: rgba(15, 22, 41, 0.08);
            --sh-sm: 0 2px 10px rgba(59, 111, 232, 0.07);
            --sh-md: 0 8px 28px rgba(59, 111, 232, 0.12);
            --sh-lg: 0 18px 52px rgba(59, 111, 232, 0.16);
            --r: 12px;
            --r-lg: 18px;
            font-family: 'DM Sans', -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--ink);
            padding: 24px 28px 48px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ══ FLASH ═══════════════════════════════════════════════ */
        .pe-flash {
            padding: 12px 18px;
            border-radius: var(--r);
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .pe-flash-ok {
            background: var(--green-lt);
            border: 1px solid rgba(18, 183, 106, 0.22);
            color: #087A42;
        }

        .pe-flash-err {
            background: var(--red-lt);
            border: 1px solid rgba(239, 68, 68, 0.22);
            color: #991B1B;
        }

        .pe-flash svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        /* ══ HERO ════════════════════════════════════════════════ */
        .pe-hero {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--sh-sm);
            overflow: hidden;
        }

        .pe-hero-cover {
            height: 72px;
            background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 36%, #3B6FE8 66%, #6B4FDB 100%);
            position: relative;
            overflow: hidden;
        }

        .pe-hero-cover::before {
            content: '';
            position: absolute;
            top: -40px;
            right: 80px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .pe-hero-cover::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 40px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .pe-hero-body {
            padding: 0 24px 20px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-top: 2px;
        }

        .pe-hero-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--indigo), var(--blue));
            border: 3px solid var(--white);
            box-shadow: 0 4px 14px rgba(107, 79, 219, 0.30);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pe-hero-icon svg {
            width: 22px;
            height: 22px;
            stroke: #fff;
            fill: none;
            stroke-width: 1.75;
        }

        .pe-hero-title {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.3px;
        }

        .pe-hero-sub {
            font-size: 12.5px;
            color: var(--ink3);
            margin-top: 2px;
        }

        /* ── Stat tiles ─────────────────────────────────────────── */
        .pe-tiles {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .pe-tile {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--sh-sm);
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            position: relative;
            overflow: hidden;
            transition: box-shadow .18s, transform .18s;
        }

        .pe-tile:hover {
            box-shadow: var(--sh-md);
            transform: translateY(-2px);
        }

        .pe-tile-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            border-radius: 20px 0 0 20px;
        }

        .pe-tile-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pe-tile-icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke-width: 2;
        }

        .pe-tile-lbl {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--ink4);
            margin-bottom: 3px;
        }

        .pe-tile-val {
            font-family: 'Sora', sans-serif;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.4px;
            line-height: 1;
        }

        .pe-tile-sub {
            font-size: 11px;
            color: var(--ink4);
            margin-top: 3px;
        }

        .pe-t-blue .pe-tile-bar {
            background: var(--blue);
        }

        .pe-t-blue .pe-tile-icon {
            background: var(--blue-lt);
        }

        .pe-t-blue .pe-tile-icon svg {
            stroke: var(--blue);
        }

        .pe-t-blue .pe-tile-val {
            color: var(--blue-2);
        }

        .pe-t-green .pe-tile-bar {
            background: var(--green);
        }

        .pe-t-green .pe-tile-icon {
            background: var(--green-lt);
        }

        .pe-t-green .pe-tile-icon svg {
            stroke: var(--green);
        }

        .pe-t-green .pe-tile-val {
            color: var(--green);
        }

        .pe-t-purple .pe-tile-bar {
            background: var(--indigo);
        }

        .pe-t-purple .pe-tile-icon {
            background: var(--purple-lt);
        }

        .pe-t-purple .pe-tile-icon svg {
            stroke: var(--indigo);
        }

        .pe-t-purple .pe-tile-val {
            color: var(--indigo);
        }

        .pe-t-amber .pe-tile-bar {
            background: var(--amber);
        }

        .pe-t-amber .pe-tile-icon {
            background: var(--amber-lt);
        }

        .pe-t-amber .pe-tile-icon svg {
            stroke: var(--amber);
        }

        .pe-t-amber .pe-tile-val {
            color: var(--amber);
        }

        /* ══ TOOLBAR ═════════════════════════════════════════════ */
        .pe-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--sh-sm);
            padding: 14px 18px;
        }

        .pe-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 13px;
            flex: 1;
            min-width: 200px;
            transition: border-color .15s, box-shadow .15s;
        }

        .pe-search:focus-within {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(59, 111, 232, 0.09);
        }

        .pe-search svg {
            width: 14px;
            height: 14px;
            stroke: var(--ink4);
            fill: none;
            flex-shrink: 0;
        }

        .pe-search input {
            border: none;
            background: transparent;
            font-size: 13.5px;
            color: var(--ink);
            outline: none;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        .pe-search input::placeholder {
            color: var(--ink4);
        }

        .pe-sel {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 30px 8px 12px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink2);
            outline: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            -webkit-appearance: none;
            transition: border-color .15s;
        }

        .pe-sel:focus {
            border-color: var(--blue);
        }

        /* ══ BUTTONS ═════════════════════════════════════════════ */
        .pe-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: var(--r);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }

        .pe-btn svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .pe-btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 111, 232, 0.28);
        }

        .pe-btn-primary:hover {
            background: var(--blue-2);
            transform: translateY(-1px);
        }

        .pe-btn-ghost {
            background: var(--blue-lt);
            color: var(--blue);
            border: 1px solid var(--blue-brd);
        }

        .pe-btn-ghost:hover {
            background: var(--blue-mid);
        }

        .pe-btn-outline {
            background: var(--white);
            color: var(--ink2);
            border: 1px solid var(--border);
        }

        .pe-btn-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .pe-btn-green {
            background: var(--green-lt);
            color: #087A42;
            border: 1px solid rgba(18, 183, 106, 0.22);
        }

        .pe-btn-green:hover {
            background: rgba(18, 183, 106, 0.16);
        }

        .pe-btn-danger {
            background: var(--red-lt);
            color: var(--red);
            border: 1px solid rgba(239, 68, 68, 0.22);
        }

        .pe-btn-danger:hover {
            background: rgba(239, 68, 68, 0.15);
        }

        .pe-btn-sm {
            padding: 5px 11px;
            font-size: 12px;
        }

        /* ══ BADGE ═══════════════════════════════════════════════ */
        .pe-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }

        .pb-green {
            background: var(--green-lt);
            color: #087A42;
        }

        .pb-amber {
            background: var(--amber-lt);
            color: #92400E;
        }

        .pb-red {
            background: var(--red-lt);
            color: #991B1B;
        }

        .pb-blue {
            background: var(--blue-lt);
            color: var(--blue-2);
        }

        .pb-purple {
            background: var(--purple-lt);
            color: var(--purple);
        }

        .pb-gray {
            background: var(--bg);
            color: var(--ink3);
            border: 1px solid var(--border);
        }

        /* ══ TABLE CARD ══════════════════════════════════════════ */
        .pe-card {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--sh-sm);
            overflow: hidden;
        }

        .pe-card-hd {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
        }

        .pe-card-hd-left {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .pe-card-ico {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--purple-lt);
            border: 1px solid rgba(124, 58, 237, 0.20);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pe-card-ico svg {
            width: 14px;
            height: 14px;
            stroke: var(--indigo);
            fill: none;
            stroke-width: 2;
        }

        .pe-card-title {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 800;
            color: var(--ink);
        }

        .pe-card-sub {
            font-size: 11.5px;
            color: var(--ink4);
            margin-top: 1px;
        }

        .pe-table-wrap {
            overflow-x: auto;
        }

        table.pe-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pe-table thead tr {
            background: #FAFBFF;
            border-bottom: 1px solid var(--border);
        }

        .pe-table th {
            padding: 10px 16px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--ink4);
            text-align: left;
            white-space: nowrap;
        }

        .pe-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .12s;
        }

        .pe-table tbody tr:last-child {
            border-bottom: none;
        }

        .pe-table tbody tr:hover {
            background: #F8FAFF;
        }

        .pe-table td {
            padding: 12px 16px;
            font-size: 13px;
            color: var(--ink2);
        }

        .pe-code {
            font-family: 'Sora', sans-serif;
            font-size: 11px;
            font-weight: 800;
            background: var(--purple-lt);
            color: var(--indigo);
            border: 1px solid rgba(107, 79, 219, 0.20);
            padding: 3px 9px;
            border-radius: 7px;
            letter-spacing: .04em;
        }

        .pe-emp-cell {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .pe-emp-av {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--indigo), var(--blue));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            font-size: 11px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .pe-emp-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
        }

        .pe-emp-dept {
            font-size: 11px;
            color: var(--ink4);
        }

        .pe-amount {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 800;
            color: var(--ink);
        }

        .pe-amount-sub {
            font-size: 10.5px;
            color: var(--ink4);
            margin-top: 1px;
        }

        .pe-actions {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        /* ══ EMPTY ═══════════════════════════════════════════════ */
        .pe-empty {
            padding: 56px 32px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .pe-empty-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--purple-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .pe-empty-icon svg {
            width: 22px;
            height: 22px;
            stroke: var(--indigo);
            fill: none;
            stroke-width: 1.5;
        }

        .pe-empty-ttl {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--ink2);
        }

        .pe-empty-sub {
            font-size: 13px;
            color: var(--ink4);
        }

        /* ══ MODAL ═══════════════════════════════════════════════ */
        .pe-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(15, 22, 41, 0.52);
            backdrop-filter: blur(10px);
            z-index: 9000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .pe-modal {
            background: var(--white);
            border-radius: var(--r-lg);
            box-shadow: var(--sh-lg);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 700px;
            max-height: 93vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .pe-modal-lg {
            max-width: 780px;
        }

        .pe-modal-hd {
            background: linear-gradient(105deg, #1A3FA8, var(--indigo) 55%, var(--blue) 100%);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .pe-modal-hd-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pe-modal-hd-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pe-modal-hd-icon svg {
            width: 17px;
            height: 17px;
            stroke: #fff;
            fill: none;
            stroke-width: 2;
        }

        .pe-modal-title {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
        }

        .pe-modal-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, .65);
            margin-top: 1px;
        }

        .pe-modal-close {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.18);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .15s;
            flex-shrink: 0;
        }

        .pe-modal-close:hover {
            background: rgba(255, 255, 255, 0.30);
        }

        .pe-modal-close svg {
            width: 14px;
            height: 14px;
            stroke: #fff;
            fill: none;
            stroke-width: 2.5;
        }

        .pe-modal-body {
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pe-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-shrink: 0;
            position: sticky;
            bottom: 0;
            background: var(--white);
            z-index: 2;
        }

        /* ── Fields ─────────────────────────────────────────── */
        .pe-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pe-field label {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: var(--ink4);
        }

        .pe-field label .req {
            color: var(--red);
        }

        .pe-field input,
        .pe-field select,
        .pe-field textarea {
            width: 100%;
            padding: 9px 13px;
            box-sizing: border-box;
            background: #F6F8FC;
            border: 1.5px solid var(--border);
            border-radius: var(--r);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .pe-field input:focus,
        .pe-field select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(59, 111, 232, 0.09);
            background: var(--white);
        }

        .pe-field input[readonly] {
            background: var(--bg);
            color: var(--ink3);
            cursor: default;
        }

        .pe-field-err {
            font-size: 11.5px;
            color: var(--red);
            font-weight: 600;
            margin-top: 2px;
        }

        .pe-grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .pe-grid3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 14px;
        }

        .pe-section-lbl {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .10em;
            color: var(--ink4);
            padding: 4px 0 2px;
            border-bottom: 1px solid var(--border);
        }

        /* ── Calc preview card ────────────────────────────────── */
        .pe-calc-preview {
            background: linear-gradient(105deg, var(--blue-lt), rgba(107, 79, 219, 0.06));
            border: 1px solid var(--blue-brd);
            border-radius: var(--r);
            padding: 14px 16px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .pe-calc-item {
            text-align: center;
        }

        .pe-calc-lbl {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--ink4);
            margin-bottom: 4px;
        }

        .pe-calc-val {
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 800;
            color: var(--blue-2);
        }

        .pe-calc-item.total .pe-calc-val {
            color: var(--indigo);
            font-size: 18px;
        }

        /* ══ VIEW MODAL ══════════════════════════════════════════ */
        .pe-view-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .pe-view-row {
            display: flex;
            flex-direction: column;
            gap: 3px;
            padding: 10px 14px;
            background: var(--bg);
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .pe-view-row.full {
            grid-column: 1 / -1;
        }

        .pe-view-lbl {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--ink4);
        }

        .pe-view-val {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink);
        }

        /* Payroll breakdown in view */
        .pe-breakdown {
            background: linear-gradient(105deg, var(--blue-lt), rgba(107, 79, 219, 0.06));
            border: 1px solid var(--blue-brd);
            border-radius: var(--r);
            padding: 16px 18px;
            grid-column: 1 / -1;
        }

        .pe-breakdown-title {
            font-family: 'Sora', sans-serif;
            font-size: 12px;
            font-weight: 800;
            color: var(--indigo);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .pe-breakdown-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            border-bottom: 1px solid rgba(59, 111, 232, 0.09);
            font-size: 13px;
        }

        .pe-breakdown-row:last-child {
            border-bottom: none;
            font-weight: 800;
            font-size: 14px;
            color: var(--indigo);
        }

        .pe-breakdown-row span:first-child {
            color: var(--ink3);
            font-weight: 600;
        }

        .pe-breakdown-row span:last-child {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            color: var(--ink);
        }

        /* ══ DELETE ══════════════════════════════════════════════ */
        .pe-del-modal {
            max-width: 420px;
        }

        .pe-del-body {
            padding: 28px 26px;
            text-align: center;
        }

        .pe-del-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--red-lt);
            border: 1px solid rgba(239, 68, 68, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }

        .pe-del-icon svg {
            width: 22px;
            height: 22px;
            stroke: var(--red);
            fill: none;
            stroke-width: 2;
        }

        .pe-del-ttl {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .pe-del-sub {
            font-size: 13px;
            color: var(--ink3);
            line-height: 1.6;
        }

        /* ══ PAGINATION ══════════════════════════════════════════ */
        .pe-pager {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pe-pager-info {
            font-size: 12.5px;
            color: var(--ink4);
            font-weight: 600;
        }

        @media (max-width: 768px) {

            .pe-grid2,
            .pe-grid3 {
                grid-template-columns: 1fr;
            }

            .pe-view-grid {
                grid-template-columns: 1fr;
            }

            .pe-tiles {
                grid-template-columns: 1fr 1fr;
            }

            .pe-calc-preview {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .pe-tiles {
                grid-template-columns: 1fr;
            }
        }
    </style>

    {{-- ── Flash ────────────────────────────────────────────── --}}
    @if(session()->has('success'))
        <div class="pe-flash pe-flash-ok">
            <svg viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="pe-flash pe-flash-err">
            <svg viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ══ GENERATE PAYSLIP MODAL ══════════════════════════════ --}}
    @if($showGenerateModal)
        <div class="pe-modal-bg" wire:click.self="closeGenerateModal">
            <div class="pe-modal">
                <div class="pe-modal-hd">
                    <div class="pe-modal-hd-left">
                        <div class="pe-modal-hd-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                        </div>
                        <div>
                            <div class="pe-modal-title">
                                {{ $generateEditingId ? 'Edit Payslip Entry' : 'Generate Payslip Entry' }}</div>
                            <div class="pe-modal-sub">
                                {{ $generateEditingId ? 'Update payslip details and calculations' : 'Generate payslip with automatic tax calculations' }}
                            </div>
                        </div>
                    </div>
                    <button class="pe-modal-close" wire:click="closeGenerateModal">
                        <svg viewBox="0 0 24 24">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <div class="pe-modal-body">
                    @if(!$generateEditingId)
                        {{-- Payroll Entry Selection for New Payslip --}}
                        <div class="pe-grid2">
                            <div>
                                <label class="pe-label">Select Payroll Entry</label>
                                <select class="pe-sel" wire:model.live="generatePayrollEntryId">
                                    <option value="">Choose payroll entry...</option>
                                    @foreach(\App\Models\PayrollEntry::with('employee')->orderBy('created_at', 'desc')->limit(50)->get() as $entry)
                                        <option value="{{ $entry->id }}">
                                            {{ $entry->code }} - {{ $entry->employee?->first_name }}
                                            {{ $entry->employee?->last_name }} ({{ number_format($entry->total_amount, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('generatePayrollEntryId')
                                    <div class="pe-err">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @else
                        {{-- Payroll Entry Info for Edit --}}
                        <div class="pe-grid2">
                            <div>
                                <label class="pe-label">Payroll Entry</label>
                                <div
                                    style="padding: 8px; background: var(--bg-light); border-radius: 4px; font-size: 12px; border: 1px solid var(--border);">
                                    @php
                                        $payrollEntry = \App\Models\PayrollEntry::find($generatePayrollEntryId);
                                    @endphp
                                    @if($payrollEntry)
                                        <strong>{{ $payrollEntry->code }}</strong> - {{ $payrollEntry->employee?->first_name }}
                                        {{ $payrollEntry->employee?->last_name }}
                                        ({{ number_format($payrollEntry->total_amount, 2) }})
                                    @else
                                        Payroll entry not found
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($generatePayrollEntryId)
                        @php
                            $selectedEntry = \App\Models\PayrollEntry::find($generatePayrollEntryId);
                            if ($selectedEntry) {
                                // Always update form values when payroll entry changes
                                $this->grossPay = (string) $selectedEntry->total_amount;
                                $this->recalculate();
                            }
                        @endphp

                        {{-- Editable Payslip Fields --}}
                        <div
                            style="margin-top: 16px; padding: 16px; background: var(--bg); border-radius: var(--r); border: 1px solid var(--border);">
                            <div style="font-weight: 600; color: var(--ink2); margin-bottom: 12px;">Edit Payslip Details:</div>
                            <button type="button" class="pe-btn pe-btn-outline pe-btn-sm" style="margin-bottom: 8px;"
                                wire:click="refreshPayrollData">
                                <svg viewBox="0 0 24 24">
                                    <path d="M4 4v3a2 2 0 00-2 2h12a2 2 0 002 2v-3" />
                                    <line x1="9" y1="9" x2="15" y2="9" />
                                    <line x1="15" y1="9" x2="9" y2="15" />
                                </svg>
                                Refresh Data
                            </button>

                            {{-- Gross Pay Section --}}
                            <div class="pe-section-lbl" style="font-size: 12px; margin-bottom: 8px;">Gross Pay Information</div>
                            <div class="pe-grid2" style="margin-bottom: 12px;">
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Gross Pay (RWF)</label>
                                    <input type="number" wire:model.live="grossPay" wire:input="recalculate" placeholder="0.00"
                                        step="0.01" min="0" style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Taxable Income (RWF)</label>
                                    <input type="number" wire:model="taxableIncome" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                            </div>

                            {{-- Additional Benefits --}}
                            <div class="pe-section-lbl" style="font-size: 12px; margin-bottom: 8px;">Additional Benefits</div>
                            <div class="pe-grid2" style="margin-bottom: 12px;">
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Housing Allowance (RWF)</label>
                                    <input type="number" wire:model.live="housingAllowance" placeholder="0.00" step="0.01"
                                        min="0" style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Transport Allowance (RWF)</label>
                                    <input type="number" wire:model.live="transportAllowance" placeholder="0.00" step="0.01"
                                        min="0" style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Meal Allowance (RWF)</label>
                                    <input type="number" wire:model.live="mealAllowance" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Other Benefits (RWF)</label>
                                    <input type="number" wire:model.live="otherBenefits" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                            </div>

                            {{-- Additional Deductions --}}
                            <div class="pe-section-lbl" style="font-size: 12px; margin-bottom: 8px;">Additional Deductions</div>
                            <div class="pe-grid2" style="margin-bottom: 12px;">
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Loan Deduction (RWF)</label>
                                    <input type="number" wire:model.live="loanDeduction" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Advance Deduction (RWF)</label>
                                    <input type="number" wire:model.live="advanceDeduction" placeholder="0.00" step="0.01"
                                        min="0" style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Other Deductions (RWF)</label>
                                    <input type="number" wire:model.live="otherDeductions" placeholder="0.00" step="0.01"
                                        min="0" style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">CBHI (RWF)</label>
                                    <input type="number" wire:model.live="cbhi" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                            </div>

                            {{-- Tax Override Options --}}
                            <div class="pe-section-lbl" style="font-size: 12px; margin-bottom: 8px;">Tax Configuration</div>
                            <div class="pe-field" style="margin-bottom: 12px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 11px;">
                                    <input type="checkbox" wire:model="overrideAutoTax" style="width: auto;">
                                    <span>Override Automatic Tax Calculation</span>
                                </label>
                            </div>

                            @if($overrideAutoTax)
                                <div class="pe-grid2" style="margin-bottom: 12px;">
                                    <div class="pe-field" style="margin-bottom: 8px;">
                                        <label style="font-size: 11px;">Custom Tax Rate (%)</label>
                                        <input type="number" wire:model="customTaxRate" placeholder="15.0" step="0.1" min="0"
                                            max="100" style="font-size: 12px; padding: 6px;">
                                    </div>
                                    <div class="pe-field" style="margin-bottom: 8px;">
                                        <label style="font-size: 11px;">Manual Tax Amount (RWF)</label>
                                        <input type="number" wire:model="manualTaxAmount" placeholder="0.00" step="0.01" min="0"
                                            style="font-size: 12px; padding: 6px;">
                                    </div>
                                </div>
                            @endif

                            {{-- Editable Calculation Fields --}}
                            <div class="pe-section-lbl" style="font-size: 12px; margin-bottom: 8px;">Tax & Deduction
                                Calculations (Editable)</div>
                            <div class="pe-grid2" style="margin-bottom: 12px;">
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Gross + Benefits (RWF)</label>
                                    <input type="number" wire:model.live="adjustedGrossPay" placeholder="0.00" step="0.01"
                                        min="0" style="font-size: 12px; padding: 6px; background: var(--bg);" readonly>
                                </div>
                                <div class="pe-grid2">
                                    <div class="pe-field" style="margin-bottom: 8px;">
                                        <label style="font-size: 11px;">Pension Rate (%) <span
                                                style="color: var(--indigo); font-size: 9px;">Editable</span></label>
                                        <input type="number" wire:model.live="pensionRate" placeholder="3.0" step="0.1" min="0"
                                            max="100" style="font-size: 12px; padding: 6px;">
                                    </div>
                                    <div class="pe-field" style="margin-bottom: 8px;">
                                        <label style="font-size: 11px;">Pension Amount (RWF) <span
                                                style="color: var(--ink4); font-size: 9px;">Calculated</span></label>
                                        <input type="number" wire:model="pension" placeholder="0.00" step="0.01" min="0"
                                            style="font-size: 12px; padding: 6px; background: var(--bg);" readonly>
                                    </div>
                                </div>
                                <div class="pe-grid2">
                                    <div class="pe-field" style="margin-bottom: 8px;">
                                        <label style="font-size: 11px;">Maternity Rate (%) <span
                                                style="color: var(--indigo); font-size: 9px;">Editable</span></label>
                                        <input type="number" wire:model.live="maternityRate" placeholder="0.3" step="0.1"
                                            min="0" max="100" style="font-size: 12px; padding: 6px;">
                                    </div>
                                    <div class="pe-field" style="margin-bottom: 8px;">
                                        <label style="font-size: 11px;">Maternity Amount (RWF) <span
                                                style="color: var(--ink4); font-size: 9px;">Calculated</span></label>
                                        <input type="number" wire:model="maternity" placeholder="0.00" step="0.01" min="0"
                                            style="font-size: 12px; padding: 6px; background: var(--bg);" readonly>
                                    </div>
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Taxable Income (RWF) <span
                                            style="color: var(--indigo); font-size: 9px;">Editable</span></label>
                                    <input type="number" wire:model.live="taxableIncome" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">PAYE (Tax) (RWF) <span
                                            style="color: var(--indigo); font-size: 9px;">Editable</span></label>
                                    <input type="number" wire:model.live="paye" placeholder="0.00" step="0.01" min="0"
                                        style="font-size: 12px; padding: 6px;">
                                </div>
                                <div class="pe-field" style="margin-bottom: 8px;">
                                    <label style="font-size: 11px;">Total Deductions (RWF) <span
                                            style="color: var(--indigo); font-size: 9px;">Calculated</span></label>
                                    <input type="number" wire:model.live="totalDeductions" placeholder="0.00" step="0.01"
                                        min="0" style="font-size: 12px; padding: 6px; background: var(--bg);" readonly>
                                </div>
                            </div>

                            {{-- Final Net Pay Preview --}}
                            <div class="pe-section-lbl" style="font-size: 12px; margin-bottom: 8px;">Final Net Pay</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                                <div
                                    style="background: var(--green-lt); padding: 12px; border-radius: var(--r); text-align: center;">
                                    <div style="font-size: 10px; color: #087A42; margin-bottom: 4px;">Net Pay</div>
                                    <div style="font-size: 16px; font-weight: 800; color: #087A42;">
                                        {{ number_format((float) ($this->netPay ?: 0), 2) }}</div>
                                </div>
                                @if($effectiveTaxRate)
                                    <div
                                        style="background: var(--blue-lt); padding: 12px; border-radius: var(--r); text-align: center;">
                                        <div style="font-size: 10px; color: var(--blue); margin-bottom: 4px;">Effective Tax Rate
                                        </div>
                                        <div style="font-size: 16px; font-weight: 800; color: var(--blue);">{{ $effectiveTaxRate }}%
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pe-modal-footer">
                    <button class="pe-btn pe-btn-outline" wire:click="closeGenerateModal">Cancel</button>
                    <button class="pe-btn pe-btn-indigo" wire:click="generatePayslip" wire:loading.attr="disabled">
                        <svg viewBox="0 0 24 24">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                        </svg>
                        <span wire:loading.remove
                            wire:target="generatePayslip">{{ $generateEditingId ? 'Update Payslip' : 'Generate Payslip' }}</span>
                        <span wire:loading
                            wire:target="generatePayslip">{{ $generateEditingId ? 'Updating…' : 'Generating…' }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ══ HERO ════════════════════════════════════════════════ --}}
    <div class="pe-hero">
        <div class="pe-hero-cover"></div>
        <div class="pe-hero-body">
            <div style="display:flex;align-items:flex-end;gap:14px;">
                <div class="pe-hero-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <div>
                    <div class="pe-hero-title">Payroll Entries</div>
                    <div class="pe-hero-sub">Calculate and manage individual employee payroll — days, overtime and
                        totals auto-calculated</div>
                </div>
            </div>
            <button class="pe-btn pe-btn-indigo" wire:click="openGenerateModal" style="margin-left: 8px;">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
                Generate Payslip
            </button>
        </div>
    </div>

    {{-- ══ STAT TILES ══════════════════════════════════════════ --}}
    <div class="pe-tiles">
        <div class="pe-tile pe-t-blue">
            <div class="pe-tile-bar"></div>
            <div class="pe-tile-icon"><svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg></div>
            <div>
                <div class="pe-tile-lbl">Total Entries</div>
                <div class="pe-tile-val">{{ $totalCount }}</div>
                <div class="pe-tile-sub">all records</div>
            </div>
        </div>
        <div class="pe-tile pe-t-green">
            <div class="pe-tile-bar"></div>
            <div class="pe-tile-icon"><svg viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12" />
                </svg></div>
            <div>
                <div class="pe-tile-lbl">Approved</div>
                <div class="pe-tile-val">{{ $approvedCount }}</div>
                <div class="pe-tile-sub">approved entries</div>
            </div>
        </div>
        <div class="pe-tile pe-t-purple">
            <div class="pe-tile-bar"></div>
            <div class="pe-tile-icon"><svg viewBox="0 0 24 24">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg></div>
            <div>
                <div class="pe-tile-lbl">Paid Out</div>
                <div class="pe-tile-val">{{ $paidCount }}</div>
                <div class="pe-tile-sub">marked as paid</div>
            </div>
        </div>
        <div class="pe-tile pe-t-amber">
            <div class="pe-tile-bar"></div>
            <div class="pe-tile-icon"><svg viewBox="0 0 24 24">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg></div>
            <div>
                <div class="pe-tile-lbl">Approved Total (RWF)</div>
                <div class="pe-tile-val" style="font-size:16px;">{{ number_format($totalPayroll, 0) }}</div>
                <div class="pe-tile-sub">gross payroll</div>
            </div>
        </div>
    </div>

    {{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
    <div class="pe-toolbar">
        <div class="pe-search">
            <svg viewBox="0 0 24 24" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Search by code, employee or payroll month…">
        </div>
        <select class="pe-sel" wire:model.live="filterMonth">
            <option value="">All Months</option>
            @foreach($payrollMonths as $pm)
                <option value="{{ $pm['id'] }}">{{ $pm['code'] }} — {{ $pm['name'] }}</option>
            @endforeach
        </select>
        <select class="pe-sel" wire:model.live="filterStatus">
            <option value="">All Statuses</option>
            @foreach($statuses as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
        <select class="pe-sel" wire:model.live="filterApproval">
            <option value="">All Approvals</option>
            @foreach($approvalStatuses as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    {{-- ══ TABLE ═══════════════════════════════════════════════ --}}
    <div class="pe-card">
        <div class="pe-card-hd">
            <div class="pe-card-hd-left">
                <div class="pe-card-ico">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <div>
                    <div class="pe-card-title">Payslip Register</div>
                    <div class="pe-card-sub">{{ $records->total() }} record{{ $records->total() != 1 ? 's' : '' }}</div>
                </div>
            </div>
        </div>


        <div class="pe-table-wrap">
            <table class="pe-table">
                <thead>
                    <tr>
                        <th>Payslip Code</th>
                        <th>Employee</th>
                        <th>Work Days</th>
                        <th>Overtime Hours</th>
                        <th>Overtime Amount</th>
                        <th>Gross Pay</th>
                        <th>Net Pay</th>
                        <th>Pension</th>
                        <th>PAYE Tax</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $row)
                        @php
                            $emp = $row->employee;
                            $empInit = $emp ? strtoupper(substr($emp->first_name ?? '', 0, 1) . substr($emp->last_name ?? '', 0, 1)) : '??';
                            $payrollEntry = $row->payrollEntry;
                            $workDays = $payrollEntry ? $payrollEntry->work_days : 0;
                            $overtimeHours = $payrollEntry ? $payrollEntry->overtime_hours_worked : 0;
                            $overtimeAmount = $payrollEntry ? $payrollEntry->overtime_total_amount : 0;
                            $st = $row->status instanceof \BackedEnum ? $row->status->value : ($row->status ?? 'draft');
                            $ap = $row->approval_status instanceof \BackedEnum ? $row->approval_status->value : ($row->approval_status ?? 'pending');
                            $stCls = match ($st) { 'paid' => 'pb-green', 'processed' => 'pb-blue', 'cancelled' => 'pb-red', default => 'pb-gray'};
                            $apCls = match ($ap) { 'approved' => 'pb-green', 'rejected' => 'pb-red', 'cancelled' => 'pb-red', 'draft' => 'pb-gray', default => 'pb-amber'};
                        @endphp
                        <tr>
                            <td><span class="pe-code">{{ $row->code }}</span></td>
                            <td>
                                <div class="pe-emp-cell">
                                    <div class="pe-emp-av">{{ $empInit }}</div>
                                    <div>
                                        <div class="pe-emp-name">
                                            {{ $emp ? trim(($emp->first_name ?? '') . ' ' . ($emp->last_name ?? '')) : '—' }}
                                        </div>
                                        <div class="pe-emp-dept">{{ $emp?->department?->name ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $workDays }} days</td>
                            <td>{{ $overtimeHours }} hrs</td>
                            <td>RWF {{ number_format($overtimeAmount, 2) }}</td>
                            <td>
                                <div class="pe-amount">RWF {{ number_format($row->gross_pay, 2) }}</div>
                                <div class="pe-amount-sub">gross pay</div>
                            </td>
                            <td>
                                <div class="pe-amount">RWF {{ number_format($row->net_pay, 2) }}</div>
                                <div class="pe-amount-sub">net pay</div>
                            </td>
                            <td>
                                <div class="pe-amount">RWF {{ number_format($row->pension, 2) }}</div>
                                <div class="pe-amount-sub">pension</div>
                            </td>
                            <td>
                                <div class="pe-amount">RWF {{ number_format($row->paye, 2) }}</div>
                                <div class="pe-amount-sub">PAYE tax</div>
                            </td>
                            <td><span class="pe-badge {{ $stCls }}">{{ ucfirst($st) }}</span></td>
                            <td><span class="pe-badge {{ $apCls }}">{{ ucfirst($ap) }}</span></td>
                            <td>
                                <div class="pe-actions">
                                    <button class="pe-btn pe-btn-ghost pe-btn-sm" wire:click="openView('{{ $row->id }}')"
                                        title="View">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                    <button class="pe-btn pe-btn-outline pe-btn-sm" wire:click="openEdit('{{ $row->id }}')"
                                        title="Edit">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    @if($ap !== 'approved')
                                        <button class="pe-btn pe-btn-green pe-btn-sm" wire:click="approve('{{ $row->id }}')"
                                            wire:confirm="Approve this payroll entry?" title="Approve">
                                            <svg viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        </button>
                                    @endif
                                    <button class="pe-btn pe-btn-danger pe-btn-sm"
                                        wire:click="confirmDelete('{{ $row->id }}')" title="Delete">
                                        <svg viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">
                                <div class="pe-empty">
                                    <div class="pe-empty-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                        </svg>
                                    </div>
                                    <div class="pe-empty-ttl">No payroll entries found</div>
                                    <div class="pe-empty-sub">
                                        {{ $search || $filterStatus || $filterApproval || $filterMonth ? 'Try adjusting your filters.' : 'Click "Generate Payslip" to create the first payslip.' }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
            <div class="pe-pager">
                <div class="pe-pager-info">Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of
                    {{ $records->total() }}
                </div>
                {{ $records->links() }}
            </div>
        @endif
    </div>

    {{-- Removed orphaned HTML elements --}}
    {{-- <div class="pe-actions">
        <button class="pe-btn pe-btn-ghost pe-btn-sm" wire:click="openView({{ $row->id }})" title="View">
            <svg viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
            @empty
            <tr>
                <td colspan="13">
                    <div class="pe-empty">
                        <div class="pe-empty-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <div class="pe-empty-ttl">No payslip entries found</div>
                        <div class="pe-empty-sub">
                            {{ $search || $filterStatus || $filterApproval || $filterMonth ? 'Try adjusting your
                            filters.' : 'Click "Generate Payslip" to create the first payslip.' }}
                        </div>
                    </div>
                </td>
            </tr>
            @endforelse
            </tbody>
            </table>
    </div>

    @if($records->hasPages())
    <div class="pe-pager">
        <div class="pe-pager-info">Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of
            {{ $records->total() }}</div>
        {{ $records->links() }}
    </div>
    @endif
</div>

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewRecord)
    <div class="pe-modal-bg" wire:click.self="closeView">
        <div class="pe-modal pe-modal-lg">

            <div class="pe-modal-hd">
                <div class="pe-modal-hd-left">
                    <div class="pe-modal-hd-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div class="pe-modal-title">{{ $viewRecord->code }}</div>
                        @php
                            $vEmp = $viewRecord->payrollEntry?->employee ?? $viewRecord->employee ?? null;
                            $vEmpName = $vEmp ? trim(($vEmp->first_name ?? '') . ' ' . ($vEmp->last_name ?? '')) : '—';
                            $vMonth = $viewRecord->payrollEntry?->payrollMonth ?? $viewRecord->payrollMonth ?? null;
                        @endphp
                        <div class="pe-modal-sub">{{ $vEmpName }}{{ $vMonth ? ' · ' . $vMonth->name : '' }}</div>
                    </div>
                </div>
                <button class="pe-modal-close" wire:click="closeView">
                    <svg viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <div class="pe-modal-body" style="padding-top:20px;">
                @php
                    $vSt = $viewRecord->status instanceof \BackedEnum ? $viewRecord->status->value : ($viewRecord->status ?? '');
                    $vAp = $viewRecord->approval_status instanceof \BackedEnum ? $viewRecord->approval_status->value : ($viewRecord->approval_status ?? '');
                    $vStCls = match ($vSt) { 'Posted' => 'pb-green', 'Approved' => 'pb-blue', 'Printed' => 'pb-blue', 'Cancelled' => 'pb-red', default => 'pb-gray'};
                    $vApCls = match ($vAp) { 'approved' => 'pb-green', 'rejected' => 'pb-red', 'cancelled' => 'pb-red', default => 'pb-amber'};
                    $vPE = $viewRecord->payrollEntry;
                @endphp

                <div class="pe-view-grid">
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Payslip Code</div>
                        <div class="pe-view-val"><span class="pe-code">{{ $viewRecord->code }}</span></div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Employee</div>
                        <div class="pe-view-val">{{ $vEmpName }}</div>
                    </div>
                    @if($vMonth)
                        <div class="pe-view-row full">
                            <div class="pe-view-lbl">Payroll Month</div>
                            <div class="pe-view-val">
                                {{ $vMonth->name }}
                                <span style="font-size:12px;color:var(--ink4);margin-left:8px;">
                                    {{ \Carbon\Carbon::parse($vMonth->start_date)->format('M d') }} –
                                    {{ \Carbon\Carbon::parse($vMonth->end_date)->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Pay Breakdown --}}
                    <div class="pe-breakdown">
                        <div class="pe-breakdown-title">Pay Breakdown</div>
                        @if($vPE)
                            <div class="pe-breakdown-row"><span>Daily Rate</span><span>RWF
                                    {{ number_format($vPE->daily_rate, 2) }}</span></div>
                            <div class="pe-breakdown-row"><span>Work Days</span><span>{{ number_format($vPE->work_days, 1) }}
                                    days</span></div>
                            <div class="pe-breakdown-row"><span>Work Days Pay</span><span>RWF
                                    {{ number_format($vPE->work_days_pay, 2) }}</span></div>
                            @if($vPE->overtime_hours_worked > 0)
                                <div class="pe-breakdown-row"><span>Overtime ({{ number_format($vPE->overtime_hours_worked, 1) }}
                                        hrs)</span><span>RWF {{ number_format($vPE->overtime_total_amount, 2) }}</span></div>
                            @endif
                        @endif
                        <div class="pe-breakdown-row"><span>Gross Pay</span><span>RWF
                                {{ number_format($viewRecord->gross_pay, 2) }}</span></div>
                        <div class="pe-breakdown-row"><span>Pension (Employee)</span><span>– RWF
                                {{ number_format($viewRecord->pension, 2) }}</span></div>
                        <div class="pe-breakdown-row"><span>Maternity (Employee)</span><span>– RWF
                                {{ number_format($viewRecord->maternity, 2) }}</span></div>
                        <div class="pe-breakdown-row"><span>PAYE Tax</span><span>– RWF
                                {{ number_format($viewRecord->paye, 2) }}</span></div>
                        @if($viewRecord->cbhi > 0)
                            <div class="pe-breakdown-row"><span>CBHI</span><span>– RWF
                                    {{ number_format($viewRecord->cbhi, 2) }}</span></div>
                        @endif
                        @if(($viewRecord->employer_contribution ?? 0) > 0)
                            <div class="pe-breakdown-row"><span>Employer Contribution</span><span>RWF
                                    {{ number_format($viewRecord->employer_contribution, 2) }}</span></div>
                        @endif
                        <div class="pe-breakdown-row">
                            <span>Net Pay</span>
                            <span style="color:var(--green);">RWF {{ number_format($viewRecord->net_pay, 2) }}</span>
                        </div>
                    </div>

                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Taxable Income</div>
                        <div class="pe-view-val">RWF {{ number_format($viewRecord->taxable_income, 2) }}</div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Tax Bracket</div>
                        <div class="pe-view-val" style="font-size:12.5px;">{{ $viewRecord->tax_bracket_used ?: '—' }}</div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Effective Tax Rate</div>
                        <div class="pe-view-val">{{ $viewRecord->effective_tax_rate ?? 0 }}%</div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Employer Contribution</div>
                        <div class="pe-view-val">RWF {{ number_format($viewRecord->employer_contribution ?? 0, 2) }}</div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Status</div>
                        <div class="pe-view-val"><span class="pe-badge {{ $vStCls }}">{{ ucfirst($vSt) }}</span></div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Approval</div>
                        <div class="pe-view-val"><span class="pe-badge {{ $vApCls }}">{{ ucfirst($vAp) }}</span></div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Created</div>
                        <div class="pe-view-val" style="font-size:12.5px;">
                            {{ \Carbon\Carbon::parse($viewRecord->created_at)->format('M d, Y · H:i') }}</div>
                    </div>
                    <div class="pe-view-row">
                        <div class="pe-view-lbl">Last Updated</div>
                        <div class="pe-view-val" style="font-size:12.5px;">
                            {{ \Carbon\Carbon::parse($viewRecord->updated_at)->format('M d, Y · H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="pe-modal-footer">
                <button class="pe-btn pe-btn-outline" wire:click="closeView">Close</button>


                @if($vAp !== 'approved')
                    <button class="pe-btn pe-btn-green" wire:click="approve('{{ $viewRecord->id }}')"
                        wire:confirm="Are you sure you want to approve payslip {{ $viewRecord->code }}? This action cannot be undone.">
                        <svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Approve Payslip
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif
{{-- ══ DELETE CONFIRM ══════════════════════════════════════ --}}
@if($showDelete)
    <div class="pe-modal-bg" wire:click.self="cancelDelete">
        <div class="pe-modal pe-del-modal">
            <div class="pe-del-body">
                <div class="pe-del-icon">
                    <svg viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                    </svg>
                </div>
                <div class="pe-del-ttl">Delete Payroll Entry?</div>
                <div class="pe-del-sub">This will permanently remove this entry. Entries with linked payslips or payment
                    records cannot be deleted.</div>
            </div>
            <div class="pe-modal-footer" style="justify-content:center;gap:12px;">
                <button class="pe-btn pe-btn-outline" wire:click="cancelDelete">Cancel</button>
                <button class="pe-btn pe-btn-danger" wire:click="deleteRecord" wire:loading.attr="disabled">
                    <svg viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                    </svg>
                    <span wire:loading.remove wire:target="deleteRecord">Yes, Delete</span>
                    <span wire:loading wire:target="deleteRecord">Deleting…</span>
                </button>
            </div>
        </div>
    </div>
@endif

</div>{{-- /pe-root --}}

<script>
    // Payslip Entry Manager - Enhanced UI Interactions
    document.addEventListener('livewire:init', () => {
        // Initialize form enhancements
        initializeFormEnhancements();
        initializeTooltips();
        initializeValidation();
    });

    function initializeFormEnhancements() {
        // Auto-format numeric inputs
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('blur', function () {
                if (this.value && !isNaN(this.value)) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        });

        // Auto-uppercase code inputs
        document.querySelectorAll('input[wire\\:model*="code"]').forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.toUpperCase();
            });
        });
    }

    function initializeTooltips() {
        // Add helpful tooltips for key fields
        const tooltips = {
            'grossPay': 'Base salary before any deductions or benefits',
            'housingAllowance': 'Housing allowance provided by employer',
            'transportAllowance': 'Transportation allowance for work-related travel',
            'mealAllowance': 'Meal allowance provided by employer',
            'overrideAutoTax': 'Enable to manually set tax calculations'
        };

        Object.keys(tooltips).forEach(fieldName => {
            const field = document.querySelector(`[wire\\:model="${fieldName}"]`);
            if (field) {
                field.title = tooltips[fieldName];
            }
        });
    }

    function initializeValidation() {
        // Real-time validation feedback
        document.querySelectorAll('input[wire\\:model]').forEach(field => {
            field.addEventListener('input', function () {
                if (this.hasAttribute('min') && parseFloat(this.value) < parseFloat(this.getAttribute('min'))) {
                    this.style.borderColor = 'var(--red)';
                } else {
                    this.style.borderColor = '';
                }
            });
        });
    }
</script>