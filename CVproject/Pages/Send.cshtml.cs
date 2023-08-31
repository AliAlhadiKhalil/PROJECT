using CVproject.Data;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using System.ComponentModel.DataAnnotations;
using static Microsoft.EntityFrameworkCore.DbLoggerCategory.Model;

namespace CVproject.Pages
{
    public class SendModel : PageModel
    {
        [BindProperty]
        public ViewModel input { get; set; }
        public List<SelectListItem> Nationality;
        public List<string> Gender;
        public List<string> Skills;
        public ProjectContext dbcontext;
        public SendModel(ProjectContext dbcon)
        {
            Nationality = new List<SelectListItem>()
            {
                new SelectListItem { Value="lebanese", Text="LEB" },
                new SelectListItem { Value="American", Text="USA" },
                new SelectListItem { Value="Saudi", Text="KSA" },
            };

            Gender = new List<string>()
            { 
                "male","female","other"
            };

            dbcontext = dbcon;
        }   
        public string successMessage = "";
        public void OnGet()
        {

        }
        public IActionResult OnPost()
        {
             
            //if (input.FirstName !=null && input.LastName!=null && input.Email!=null && input.Email.Equals(input.ConfirmEmail) && input.DateOfBirth!=null)
            if(ModelState.IsValid)
            {
               if (input.sum != input.x+input.y)
                {
                    ModelState.AddModelError("sum", "the sum isn't correct");
                    return Page();
                }

                string skills = "";
                if(input.skill1) { skills += "C, "; }
                if(input.skill2) { skills += "C++, "; }
                if(input.skill3) { skills += "C#, "; }
                if(input.skill4) { skills += "Java, "; }
                if(input.skill5) { skills += "Python"; }

                Data.CV cv = new Data.CV() {
                    FirstName = input.FirstName,
                    LastName = input.LastName,
                    DateOfBirth = input.DateOfBirth,
                    Nationality = input.Nationality,
                    Gender = input.Gender,
                    Email = input.Email,
                    Photo = " ",
                    Skills = skills,
                };

                dbcontext.cvs.Add(cv);
                dbcontext.SaveChanges();
                ModelState.Clear();
                successMessage="CV Sent Successfully";
                return Page();  
                //return Redirect("Index");
            }
            
            return Page();

        }


    }

    public class ViewModel 
    {
        [Required(ErrorMessage ="Please enter your first name")]
        [Display(Name ="FirstName")]
        public string FirstName { get; set; }
        [Required(ErrorMessage = "Please enter your last name")]
        [Display(Name = "LastName")]
        public string LastName { get; set; }
        [Required(ErrorMessage = "Please enter your birth date")]
        [Display(Name ="Birth Date")]
        public DateTime  DateOfBirth { get; set; }

        [Display(Name = "Nationality")]
        public string Nationality { get; set; }

        [Display(Name = "Gender")]
        public string Gender { get; set; }


        [Display(Name = "C")]
        public bool skill1 { get; set; }
        [Display(Name = "C++")]
        public bool skill2 { get; set; }
        [Display(Name = "C#")]
        public bool skill3 { get; set; }
        [Display(Name = "Java")]
        public bool skill4 { get; set; }
        [Display(Name = "Python")]
        public bool skill5 { get; set; }    


        [EmailAddress]
        [Required(ErrorMessage ="Please enter your email")]
        public string Email { get; set; }

        [EmailAddress]
        [Compare("Email",ErrorMessage ="invalid, please enter the same email")]
        [Required(ErrorMessage ="Please confirm your email")]
        public string ConfirmEmail{ get; set; }
       

        [Range(1,20)]
        [Display(Name="Enter x between 1 and 20")]
        public int x { get; set; }

        [Range(20,50)]
        [Display(Name = "Enter y between 20 and 50")]
        public int y { get; set; }

        [Range(1, 70)]
        [Display(Name = "Enter sum")]
        public int sum { get; set; }
    
    }

}
