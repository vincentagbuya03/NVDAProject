@extends('format.nav')

@section('title', 'NVDA | Next-Gen Client Management')

@section('content')
    <div class="hero" style="padding: 6rem 0; min-height: 70vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
        <div class="fade-in" style="margin-bottom: 2rem;">
            <span class="badge badge-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">v2.0 Now Available</span>
        </div>
        <h1 class="fade-in" style="font-size: 4.5rem; max-width: 900px; line-height: 1.1; margin-bottom: 2rem;">
            Empower Your Business with <span class="text-gradient">Intelligent</span> Client Solutions
        </h1>
        <p class="fade-in" style="font-size: 1.25rem; color: var(--text-muted); max-width: 600px; margin-bottom: 3rem;">
            NVDA Project provides a comprehensive suite of tools designed to streamline your client management workflow and boost productivity.
        </p>
        <div class="fade-in" style="display: flex; gap: 1.5rem;">
            <a href="/clientDashboard" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1rem;">Get Started Free</a>
            <a href="/clientAboutUs" class="btn btn-secondary" style="padding: 1rem 2.5rem; font-size: 1rem;">Learn More</a>
        </div>
    </div>

    <div style="padding: 4rem 0; margin-bottom: 8rem;">
        <div style="text-align: center; margin-bottom: 5rem;">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Why Choose <span class="text-gradient">NVDA</span>?</h2>
            <p style="color: var(--text-muted);">Built for professionals who demand excellence.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="card" style="padding: 3rem; text-align: left;">
                <div style="font-size: 2.5rem; margin-bottom: 1.5rem;">⚡</div>
                <h3 style="margin-bottom: 1rem;">Lightning Fast</h3>
                <p style="color: var(--text-muted); line-height: 1.6;">Optimized for speed and efficiency, ensuring a smooth experience for you and your clients.</p>
            </div>
            <div class="card" style="padding: 3rem; text-align: left;">
                <div style="font-size: 2.5rem; margin-bottom: 1.5rem;">🔒</div>
                <h3 style="margin-bottom: 1rem;">Enterprise Security</h3>
                <p style="color: var(--text-muted); line-height: 1.6;">Advanced encryption and security multi-layer protocols to keep your sensitive data safe.</p>
            </div>
            <div class="card" style="padding: 3rem; text-align: left;">
                <div style="font-size: 2.5rem; margin-bottom: 1.5rem;">🎨</div>
                <h3 style="margin-bottom: 1rem;">Modern Interface</h3>
                <p style="color: var(--text-muted); line-height: 1.6;">A clean, intuitive design that makes managing clients a breeze and looks great on all devices.</p>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 8rem;">
        <div class="card" style="padding: 0; display: grid; grid-template-columns: 1fr 1fr; background: var(--text-main); color: white; border: none;">
            <div style="padding: 5rem;">
                <h2 style="font-size: 3rem; margin-bottom: 2rem; line-height: 1.2;">Ready to transform your <span class="text-gradient">workflow</span>?</h2>
                <p style="font-size: 1.125rem; opacity: 0.8; margin-bottom: 3rem;">Join thousands of businesses already using NVDA to scale their operations.</p>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" class="btn btn-primary" style="padding: 1rem 2rem;">Start Your Trial</a>
                    <a href="#" class="btn btn-secondary" style="background: transparent; color: white; border-color: rgba(255,255,255,0.2); padding: 1rem 2rem;">Contact Sales</a>
                </div>
            </div>
            <div style="background: linear-gradient(45deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 10rem; opacity: 0.9;">
                📊
            </div>
        </div>
    </div>
@endsection
