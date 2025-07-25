@extends('admin.layout.default')

@section('dashboard','active menu-item-open')
@section('content')
<div class="card card-custom shadow-lg" style="min-height: 75vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%); border-radius: 1.5rem; position: relative; overflow: hidden;">
    <!-- Background Image -->
    {{-- <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=800&q=80" alt="Car" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.18; z-index: 1; border-radius: 1.5rem;"> --}}
    <div class="card-body d-flex align-items-center justify-content-center w-100 h-100" style="height: 75vh; position: relative; z-index: 2;">
        <div class="text-center w-100">
            <div style="color: #2d3748; font-size: 2.2rem; font-weight: bold; letter-spacing: 1px;">
                Welcome to <span style="color: #007bff;">Perfect Driving School Ghugus</span>
            </div>
            <div style="color: #4a5568; font-size: 1.15rem; margin-top: 1rem;">
                Effortlessly oversee your driving school operations, students, and schedules.<br>
                <span style="color: #007bff; font-weight: 500;">Empowering you for success every day!</span>
            </div>
            <div style="margin-top: 2rem;">
                <i class="la la-hand-peace" style="font-size: 3rem; color: #38b2ac;"></i>
            </div>
            <div style="margin-top: 2.5rem; color: #2d3748; font-size: 1.1rem;">
                <strong>Contact Person:</strong> Shubham Bramhane<br>
                <strong>Contact No for any Query:</strong> <a href="tel:8857916707" style="color: #007bff; text-decoration: underline;">8857916707</a>
            </div>
            <div style="margin-top: 1rem; color: #4a5568; font-size: 1rem;">
                <strong>Developed by:</strong> Shubham Bramhane
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Styles Section --}}



@section('styles')

@endsection


{{-- Scripts Section --}}



@section('scripts')
@endsection
