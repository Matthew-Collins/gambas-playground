using System;
using System.Net.Http;
using System.Threading.Tasks;
using Microsoft.VisualBasic;
using Microsoft.VisualBasic.CompilerServices;

namespace Gambas_Playground
{

    public class WebSandbox
    {

        public Uri Host { get; set; } = new Uri("https://pg1.gambas.one/run.php");

        public async Task<string> Run(string Code)
        {

            // Clean Line Endings
            Code = Code.Replace(Constants.vbCrLf, Constants.vbLf);
            Code = Code.Replace(Constants.vbCr, Constants.vbLf);

            // Clean 66, 99 Quotes
            Code = Code.Replace(Strings.ChrW(8220), Strings.Chr(34));
            Code = Code.Replace(Strings.ChrW(8221), Strings.Chr(34));

            // Run Code in Web Sandbox
            string result = string.Empty;
            var Client = new HttpClient();
            try
            {
                var Response = await Client.PostAsync(Host, new StringContent(Code));
                if (Response.IsSuccessStatusCode)
                {
                    result = (await Response.Content.ReadAsStringAsync());
                }
            }
            catch (Exception ex)
            {
                return ex.Message;
            }

            // Clean Line Endings
            result = result.Trim(Conversions.ToChar(Constants.vbLf));
            result = result.Replace(Constants.vbCrLf, Constants.vbLf);
            result = result.Replace(Constants.vbCr, Constants.vbLf);
            result = result.Replace(Constants.vbLf, Constants.vbCrLf);

            return result;

        }

    }
}