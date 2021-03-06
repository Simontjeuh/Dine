import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { ResetRequestComponent } from './reset-request/reset-request.component';
import { PasswordResetComponent } from './password-reset/password-reset.component';
import { LandingPageComponent } from '../landing-page/landing-page.component';
import { AboutComponent } from '../about/about.component';
import { ContactComponent } from '../contact/contact.component';
import { MenuComponent } from '../menu/menu.component';
import { ProductsComponent } from '../products/products.component';
import { ProfilePageComponent } from '../profile-page/profile-page.component';
import { ShoppingCartComponent } from '../shopping-cart/shopping-cart.component';
import { CheckoutComponent } from '../checkout/checkout.component';
import { AuthGuard } from '../services/auth-guard.service';

const routes: Routes = [
  {
    path: '',
    component: LandingPageComponent
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: 'register',
    component: RegisterComponent
  },
  {
    path: 'resetrequest',
    component: ResetRequestComponent
  },
  {
    path: 'passwordreset',
    component: PasswordResetComponent
  },
  {
    path: 'about',
    component: AboutComponent
  },
  {
    path: 'contact',
    component: ContactComponent
  },
  {
    path: 'menu',
    component: MenuComponent
  },
  {
    path: 'products',
    component: ProductsComponent
  },
  {
    path: 'profile',
    component: ProfilePageComponent,
    canActivate: [AuthGuard]
  },
  {
    path: 'cart',
    component: ShoppingCartComponent
  },
  {
    path: 'checkout',
    component: CheckoutComponent,
    canActivate: [AuthGuard]
  },
  {
    // this needs some configuring
    path: '**',
    redirectTo: '',
    pathMatch: 'full'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthenticationRoutingModule { }
