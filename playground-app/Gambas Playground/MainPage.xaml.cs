namespace Gambas_Playground
{
    public partial class MainPage : ContentPage
    {
        
        public MainPage()
        {
            InitializeComponent();
        }

        private async void OnRunCode(object sender, EventArgs e)
        {
            WebSandbox sb = new();
            this.Result.Text = await sb.Run(this.Code.Text);
        }

    }
}