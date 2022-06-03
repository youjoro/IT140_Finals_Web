using Android.App;
using Android.Content;
using Android.Graphics;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using AndroidX.AppCompat.App;
using AndroidX.Core.Content;
using IronPython.Hosting;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.IO;
using System.Net;
using System.Net.Http;
using System.Reflection;
using System.Text;
using Xamarin.Essentials;

namespace Plant_Monitoring_System
{
    [Activity(Label = "Plant Monitoring System", Theme = "@style/AppTheme")]
    public class MainActivity : AppCompatActivity
    {
        TextView device_option;
        ImageView sortdown_img;
        ImageView graph_img;
        HttpClient client;
        List<String> devices = new List<String>();

        Bitmap imageBitmap;
        BackgroundWorker graph_worker;

        Toast toaster;

        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);
            Xamarin.Essentials.Platform.Init(this, savedInstanceState);
            SetContentView(Resource.Layout.plantdata);

            device_option = FindViewById<TextView>(Resource.Id.device_option);
            sortdown_img = FindViewById<ImageView>(Resource.Id.sortdown_img);
            graph_img = FindViewById<ImageView>(Resource.Id.graph_img);

            device_option.Click += Device_option_Click;
            sortdown_img.Click += Device_option_Click;

            client = new HttpClient();
            graph_worker = new BackgroundWorker();

            graph_worker.DoWork += Graph_worker_DoWork; ;
            graph_worker.RunWorkerCompleted += Graph_worker_RunWorkerCompleted;

            toaster = Toast.MakeText(this, "", ToastLength.Long);

            init_devices();

        }



        private void Device_option_Click(object sender, EventArgs e)
        {
            PopupMenu popup_menu = new PopupMenu(this, device_option);
            popup_menu.MenuItemClick += PopupMenu_MenuItemClick;

            for (var i = 0; i < devices.Count; i++)
            {
                popup_menu.Menu.Add(IMenu.None, i + 1, i + 1, devices[i].ToString());
            }

            popup_menu.Show();
        }

        private void PopupMenu_MenuItemClick(object sender, PopupMenu.MenuItemClickEventArgs e)
        {
            toaster.Cancel();
            toaster.SetText("Graph Loading");
            toaster.Show();

            var chosen_device = e.Item.TitleFormatted.ToString();
            device_option.Text = chosen_device;

            if (graph_worker.IsBusy)
            {          
                return;
            }
            
            graph_worker.RunWorkerAsync();
        }

        private void Graph_worker_DoWork(object sender, DoWorkEventArgs e)
        {
            var url = "http://192.168.68.186:8080/IT140_Finals_Web/restAPI/graph_output/graph.png";

            request_graph();

            imageBitmap = GetImageBitmapFromUrl(url);
        }

        private void Graph_worker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            graph_img.SetImageBitmap(imageBitmap);
            graph_worker.RunWorkerAsync();
        }

        
        public void logoutUser(object sender, EventArgs e)
        {
            Preferences.Clear(); 
            Intent intent = new Intent(this, typeof(Login));
            StartActivity(intent);
            Finish();
        }

        private void request_graph()
        {
            string api = "http://192.168.68.186:8080/IT140_Finals_Web/restAPI/get_device_data.php";
            api += $"?email={Preferences.Get("USER_EMAIL", string.Empty)}";
            api += $"&id={device_option.Text}";

            var api_uri = new Uri(api);

            var response = client.GetAsync(api_uri).Result;
            var json_data = response.Content.ReadAsStringAsync().Result;

            var data = JsonConvert.DeserializeObject<Device_Data[]>(json_data);

            if (data.Length == 0)
            {
                toaster.Cancel();
                toaster.SetText("Data Unavailable");
                toaster.Show();
                return;
            }
        }

        private void init_devices()
        {
            string api = "http://192.168.68.186:8080/IT140_Finals_Web/restAPI/get_all_devices.php";
            api += $"?email={Preferences.Get("USER_EMAIL", string.Empty)}";

            var api_uri = new Uri(api);

            var response = client.GetAsync(api_uri).Result;
            var json_data = response.Content.ReadAsStringAsync().Result;

            var data = JsonConvert.DeserializeObject<Device_Data[]>(json_data);

            foreach (var device in data)
            {
                devices.Add(device.DeviceId);
            }
        }

        private DateTime UnixToDateTime(string Unix_Timestamp)
        {
            DateTime dtDateTime = new DateTime(1970, 1, 1, 0, 0, 0, 0, System.DateTimeKind.Utc);
            dtDateTime = dtDateTime.AddSeconds(Convert.ToDouble(Unix_Timestamp)).ToLocalTime();
            return dtDateTime;
        }

        private Bitmap GetImageBitmapFromUrl(string url)
        {
            Bitmap imageBitmap = null;

            using (var webClient = new WebClient())
            {
                var imageBytes = webClient.DownloadData(url);

                if (imageBytes != null && imageBytes.Length > 0)
                {
                    imageBitmap = BitmapFactory.DecodeByteArray(imageBytes, 0, imageBytes.Length);
                }
            }

            return imageBitmap;
        }


        public override void OnRequestPermissionsResult(int requestCode, string[] permissions, [GeneratedEnum] Android.Content.PM.Permission[] grantResults)
        {
            Xamarin.Essentials.Platform.OnRequestPermissionsResult(requestCode, permissions, grantResults);

            base.OnRequestPermissionsResult(requestCode, permissions, grantResults);
        }


    }

    public class Device_Data
    {
        [JsonProperty("device_id")]
        public string DeviceId { get; set; }

        [JsonProperty("Temperature")]
        public string Temperature { get; set; }

        [JsonProperty("Humidity")]
        public string Humidity { get; set; }

        [JsonProperty("Moisture")]
        public string Moisture { get; set; }

        [JsonProperty("reading_time")]
        public string ReadingTime { get; set; }

    }
}