          <!-- Sign Up Form -->
          <form id="signUpForm" method="POST" action="" class="hidden">
            <div class="mb-2 text-center text-sm text-red-600"><?php echo htmlspecialchars($registerError); ?></div>
            <div class="space-y-4">
              <div>
                <label for="signUpName" class="block text-sm font-semibold text-gray-900 mb-2">Full Name</label>
                <input type="text" id="signUpName" name="name" required placeholder="John Doe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div>
                <label for="signUpContact" class="block text-sm font-semibold text-gray-900 mb-2">Contact Number</label>
                <input type="text" id="signUpContact" name="contact" required placeholder="09xxxxxxxxx" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div>
                <label for="signUpEmail" class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                <input type="email" id="signUpEmail" name="email" required placeholder="you@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div>
                <label for="signUpPassword" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                <input type="password" id="signUpPassword" name="password" required placeholder="••••••••" minlength="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div>
                <label for="signUpConfirmPassword" class="block text-sm font-semibold text-gray-900 mb-2">Confirm Password</label>
                <input type="password" id="signUpConfirmPassword" name="confirm_password" required placeholder="••••••••" minlength="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div class="flex items-start">
                <input type="checkbox" id="terms" required class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" />
                <label for="terms" class="ml-2 text-sm text-gray-600">I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Privacy Policy</a></label>
              </div>
              <button type="submit" name="register" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors">Sign Up</button>
            </div>
          </form>