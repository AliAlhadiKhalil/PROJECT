using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using CVproject.Data;

namespace CVproject.Pages
{
    public class CreateModel : PageModel
    {
        private readonly CVproject.Data.ProjectContext _context;

        public CreateModel(CVproject.Data.ProjectContext context)
        {
            _context = context;
        }

        public IActionResult OnGet()
        {
            return Page();
        }

        [BindProperty]
        public CV CV { get; set; } = default!;
        

        // To protect from overposting attacks, see https://aka.ms/RazorPagesCRUD
        public async Task<IActionResult> OnPostAsync()
        {
          if (!ModelState.IsValid || _context.cvs == null || CV == null)
            {
                return Page();
            }

            _context.cvs.Add(CV);
            await _context.SaveChangesAsync();

            return RedirectToPage("./Index");
        }
    }
}
