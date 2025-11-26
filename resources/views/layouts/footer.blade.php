<footer class="bg-[#8a2be2] text-white pt-16 pb-8 mt-16 relative overflow-hidden">
    {{-- Font Awesome link remains for styling --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Top Accent Line (Yellow) --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-[#F9DF71]"></div>

    {{-- Background Pattern/Decoration (Subtle White Circles) --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 right-10 w-32 h-32 rounded-full bg-white"></div>
        <div class="absolute bottom-20 left-10 w-24 h-24 rounded-full bg-white"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 rounded-full bg-white"></div>
    </div>

    <div class="relative z-10">
        {{-- Main Footer Content (Fluid Width) --}}
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 xl:gap-12">

                {{-- Logo + About + Newsletter (Column 1) --}}
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="https://placehold.co/48x48/8a2be2/F9DF71?text=PV" 
                             alt="Pawsitive Vibes Logo"
                             class="h-12 w-12 rounded-full object-cover border-2 border-white/20">
                        <h3 class="text-2xl lg:text-3xl font-bold tracking-wide bg-gradient-to-r from-white to-[#F9DF71] bg-clip-text text-transparent">
                            Pawsitive Vibes
                        </h3>
                    </div>

                    <p class="text-white/80 text-sm lg:text-base leading-relaxed mb-4">
                        Your trusted online pet shop offering high-quality pet essentials,
                        treats, toys, and accessories. Making every moment with your furry friends more joyful.
                    </p>
                    
                    {{-- Newsletter Signup --}}
                    <div class="mt-6">
                        <p class="text-white/90 font-medium mb-3 text-sm">Stay Updated</p>
                        <div class="flex gap-2">
                            <input type="email" 
                                   placeholder="Your email" 
                                   class="flex-1 px-3 py-2 text-sm rounded-lg border border-white/20 bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-[#F9DF71] focus:border-transparent">
                            <button class="px-4 py-2 bg-[#F9DF71] text-[#8a2be2] rounded-lg font-semibold text-sm hover:bg-yellow-300 transition-colors duration-200">
                                Join
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Quick Links (Column 2) --}}
                <div>
                    <h4 class="text-lg lg:text-xl font-semibold mb-6 pb-2 border-b border-white/20">Quick Links</h4>
                    <ul class="space-y-3 text-sm lg:text-base">
                        <li>
                            <a href="/customer/dashboard" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="/favorites" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Favorites
                            </a>
                        </li>
                        <li>
                            <a href="/donate" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Donate
                            </a>
                        </li>
                        <li>
                            <a href="/cart" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Cart
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Customer Support (Column 3) --}}
                <div>
                    <h4 class="text-lg lg:text-xl font-semibold mb-6 pb-2 border-b border-white/20">Customer Support</h4>
                    <ul class="space-y-3 text-sm lg:text-base">
                        <li>
                            <a href="#" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Shipping Policy
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Returns & Refunds
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-white/80 hover:text-[#F9DF71] transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 bg-[#F9DF71] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contact & Social (Column 4) --}}
                <div>
                    <h4 class="text-lg lg:text-xl font-semibold mb-6 pb-2 border-b border-white/20">Get in Touch</h4>
                    
                    <div class="space-y-4 text-sm lg:text-base">
                        <div class="flex items-start gap-3 text-white/80">
                            <div class="w-5 h-5 mt-0.5 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-[#F9DF71]"></i>
                            </div>
                            <p>Manila, Philippines</p>
                        </div>
                        <div class="flex items-start gap-3 text-white/80">
                            <div class="w-5 h-5 mt-0.5 flex-shrink-0">
                                <i class="fas fa-envelope text-[#F9DF71]"></i>
                            </div>
                            <a href="mailto:support@pawsitivevibes.com" class="hover:text-[#F9DF71] transition-colors duration-200">
                                support@pawsitivevibes.com
                            </a>
                        </div>
                        <div class="flex items-start gap-3 text-white/80">
                            <div class="w-5 h-5 mt-0.5 flex-shrink-0">
                                <i class="fas fa-phone text-[#F9DF71]"></i>
                            </div>
                            <a href="tel:09451234567" class="hover:text-[#F9DF71] transition-colors duration-200">
                                0945-123-4567
                            </a>
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div class="mt-8">
                        <p class="text-white/90 font-medium mb-4 text-sm">Follow Us</p>
                        <div class="flex gap-4">
                            {{-- IMPROVED FACEBOOK ICON CLASS: Ensure the `fab` class is used for brand icons --}}
                            <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#F9DF71] hover:text-[#8a2be2] transition-all duration-200 transform hover:scale-110">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#F9DF71] hover:text-[#8a2be2] transition-all duration-200 transform hover:scale-110">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#F9DF71] hover:text-[#8a2be2] transition-all duration-200 transform hover:scale-110">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#F9DF71] hover:text-[#8a2be2] transition-all duration-200 transform hover:scale-110">
                                <i class="fab fa-tiktok text-lg"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Payment Methods --}}
                    <div class="mt-6">
                        <p class="text-white/90 font-medium mb-3 text-sm">We Accept</p>
                        <div class="flex flex-wrap gap-2">
                            <div class="px-2 py-1 bg-white rounded flex items-center justify-center text-xs font-bold text-[#8a2be2] shadow-md">GCash</div>
                            <div class="px-2 py-1 bg-white rounded flex items-center justify-center text-xs font-bold text-[#8a2be2] shadow-md">Visa</div>
                            <div class="px-2 py-1 bg-white rounded flex items-center justify-center text-xs font-bold text-[#8a2be2] shadow-md">MasterCard</div>
                            <div class="px-2 py-1 bg-white rounded flex items-center justify-center text-xs font-bold text-[#8a2be2] shadow-md">BPI</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Section --}}
        <div class="w-full mt-12 pt-6 border-t border-white/20">
            <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4 text-center lg:text-left">
                    <div class="text-sm text-white/70">
                        © {{ date('Y') }} Pawsitive Vibes — All Rights Reserved.
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-6 text-sm text-white/70">
                        <a href="#" class="hover:text-[#F9DF71] transition-colors duration-200">Terms of Service</a>
                        <a href="#" class="hover:text-[#F9DF71] transition-colors duration-200">Privacy Policy</a>
                        <a href="#" class="hover:text-[#F9DF71] transition-colors duration-200">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>