@extends('format.nav')

@section('title', 'About Us')

@section('content')
    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <h1 style="margin-bottom: 0.5rem;">The <span class="text-gradient">NVDA</span> Story</h1>
        <p style="margin-bottom: 2rem;">Redefining client management with modern technology and elegant design.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-bottom: 6rem; align-items: center;">
        <div>
            <h2 style="margin-bottom: 1.5rem;">Our Mission</h2>
            <p style="color: var(--text-muted); font-size: 1.125rem; line-height: 1.75; margin-bottom: 2rem;">
                The NVDA Project is dedicated to providing innovative client management solutions that streamline workflows and enhance productivity. We believe in delivering excellence through modern technology and user-centered design, helping businesses achieve their goals with confidence and efficiency.
            </p>
            <div style="display: flex; gap: 1rem;">
                <div style="padding: 1rem; background: white; border-radius: 1rem; border: 1px solid var(--border-color); flex: 1;">
                    <h4 style="margin-bottom: 0.25rem;">100%</h4>
                    <small style="color: var(--text-muted);">Client Satisfaction</small>
                </div>
                <div style="padding: 1rem; background: white; border-radius: 1rem; border: 1px solid var(--border-color); flex: 1;">
                    <h4 style="margin-bottom: 0.25rem;">24/7</h4>
                    <small style="color: var(--text-muted);">Expert Support</small>
                </div>
            </div>
        </div>
        <div style="position: relative;">
            <div style="width: 100%; aspect-ratio: 16/9; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 1.5rem; transform: rotate(2deg); opacity: 0.1; position: absolute; top: 0; left: 0;"></div>
            <div class="card" style="padding: 3rem; position: relative; z-index: 1;">
                <div style="font-size: 3rem; margin-bottom: 1.5rem;">🚀</div>
                <h3 style="margin-bottom: 1rem;">Driven by Innovation</h3>
                <p style="color: var(--text-muted); margin-bottom: 0;">
                    We don't just follow trends; we set them. Our commitment to using the latest web technologies ensures your business stays ahead of the competition.
                </p>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 6rem;">
        <h2 style="text-align: center; margin-bottom: 4rem;">Core Values</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            <div class="card" style="padding: 2.5rem; text-align: center;">
                <div style="width: 64px; height: 64px; background: rgba(99, 102, 241, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">💡</div>
                <h3 style="margin-bottom: 1rem;">Innovation</h3>
                <p style="color: var(--text-muted); font-size: 0.875rem;">Constantly evolving to meet modern needs and exceed expectations.</p>
            </div>
            <div class="card" style="padding: 2.5rem; text-align: center;">
                <div style="width: 64px; height: 64px; background: rgba(14, 165, 233, 0.1); color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">⭐</div>
                <h3 style="margin-bottom: 1rem;">Quality</h3>
                <p style="color: var(--text-muted); font-size: 0.875rem;">High standards in every aspect of our service delivery.</p>
            </div>
            <div class="card" style="padding: 2.5rem; text-align: center;">
                <div style="width: 64px; height: 64px; background: rgba(244, 63, 94, 0.1); color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">🤝</div>
                <h3 style="margin-bottom: 1rem;">Support</h3>
                <p style="color: var(--text-muted); font-size: 0.875rem;">Dedicated to our clients' success and continuous growth.</p>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 4rem; background: linear-gradient(to bottom right, #ffffff, #f8fafc); overflow: hidden; position: relative;">
        <div style="position: absolute; right: -5%; top: -10%; font-size: 20rem; opacity: 0.03; font-weight: 800;">NVDA</div>
        <div style="max-width: 600px; position: relative; z-index: 1;">
            <h2 style="margin-bottom: 1.5rem;">Get in Touch</h2>
            <p style="color: var(--text-muted); margin-bottom: 3rem;">Have questions or want to collaborate? We'd love to hear from you.</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Contact Info</h4>
                    <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">📧 vincentagbuya3@gmail.com</p>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">📱 +63 912 235 4762</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Location</h4>
                    <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0;">
                        Turac San Carlos City,<br>
                        Pangasinan, Philippines
                    </p>
                </div>
            </div>
            <button class="btn btn-primary" style="margin-top: 3rem;">View Documentation</button>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection