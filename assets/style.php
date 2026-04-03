/* Prevent content overlap */
body {
padding-top: 85px; /* adjust between 75–110px after testing */
}

/* Glass navbar - full width, no forced centering */
.glass-navbar {
background: rgba(255, 255, 255, 0.10) !important;
backdrop-filter: blur(14px);
-webkit-backdrop-filter: blur(14px);
border-bottom: 1px solid rgba(255, 255, 255, 0.15);
box-shadow: 0 4px 18px rgba(0,0,0,0.07);
padding: 0.6rem 0; /* slim but comfortable */
z-index: 1050;
}

/* No more max-width / transform / left:50% → full width behavior */
@media (min-width: 992px) {
.glass-navbar {
/* optional: very light rounding on desktop only */
border-radius: 0 0 12px 12px;
}
}

/* Mobile: completely full width, no rounding */
@media (max-width: 991.98px) {
.glass-navbar {
border-radius: 0;
}
}

/* Links spacing - not too tight, not too wide */
.glass-navbar .nav-link.bar-link {
padding: 0.5rem 0.9rem !important;
transition: color 0.2s ease;
}

.glass-navbar .nav-link.bar-link:hover,
.glass-navbar .nav-link.bar-link.active {
color: #2e7d32 !important;
}

/* Dropdown polish */
.dropdown-menu {
border: none;
border-radius: 10px;
background: rgba(255, 255, 255, 0.96);
backdrop-filter: blur(8px);
box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}