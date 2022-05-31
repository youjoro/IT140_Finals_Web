using Android.App;
using Android.Content;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Plant_Monitoring_System
{
    [Activity(Label = "Register to Plant Monitoring System", Theme = "@style/AppTheme")]
    public class register : Activity
    {
        EditText email, pass;
        Button reg, cancel;
        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);
            SetContentView(Resource.Layout.register);
            email = FindViewById<EditText>(Resource.Id.email);
            pass = FindViewById<EditText>(Resource.Id.pass);
            reg = FindViewById<Button>(Resource.Id.register);
            cancel = FindViewById<Button>(Resource.Id.cancel);

            reg.Click += this.register_user;
            cancel.Click += this.cancelReg;
        }

        public void register_user(object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(MainActivity));
            StartActivity(intent);
        }
        public void cancelReg(object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(MainActivity));
            StartActivity(intent);
        }
    }
}